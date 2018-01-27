<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Model\Entity\User;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow(['login']);   // ログインしていなくても見れる
    }

    public function login ()
    {
        $this->request->allowMethod(['post']);

        $user_array = $this->Auth->identify();
        if (!$user_array) {
            $this->set([
                'success' => false,
                'message' => 'メールアドレスかパスワードが間違っています'
            ]);
            $this->set('_serialize', ['success', 'message']);
            return;
        }

        $user_entity = $this->Users->find()
            ->where(['id' => $user_array['id']])
            ->firstOrFail();

        // API でログインされた時に、毎回 api_token を生成する
        $this->generateApiToken($user_entity);

        $user = array_filter($user_entity->toArray(), function ($key) {
            return in_array($key, ['id', 'email', 'role', 'nickname', 'api_token']);
        }, ARRAY_FILTER_USE_KEY);
        $user['thumbnailUrl'] = $user_entity['thumbnailUrl'];

        $this->set([
            'success' => true,
            'user' => $user
        ]);
        $this->set('_serialize', ['success', 'user']);
    }

    private function generateApiToken (User $user)
    {
        $user->api_token = Text::uuid();
        $this->Users->save($user);
    }
}
