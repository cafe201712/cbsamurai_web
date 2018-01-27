<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;
use BaconQrCode\Renderer\Image\Svg;
use Cake\Validation\Validator;
use CakeDC\Users\Exception\WrongPasswordException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class ProfileController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Invitations');
    }

    public function view ()
    {
        $profile = $this->Users->find('profile', [
            'id' => $this->Auth->user('id')
        ])->firstOrFail();

        $profile->virtualProperties([
            'photoUrl',
            'thumbnailUrl',
        ]);

        $this->set([
            'success' => true,
            'profile' => $profile
        ]);

        $invitation = $this->Invitations->find('OwnedByUser', [
            'user_id' => $this->Auth->user('id'),
            'sort_order' => ['created' => 'DESC'],
        ])->first();

        if ($invitation) {
            // QRコードの生成
            $qrcode = $invitation->qrcode(new Svg());
            $this->set(compact('invitation', 'qrcode'));
        }

        $this->set('_serialize', ['success', 'profile', 'invitation', 'qrcode']);
    }

    public function edit()
    {
        $this->request->allowMethod(['patch']);

        $profile = $this->Users->get($this->Auth->user('id'));
        $profile = $this->Users->patchEntity($profile, $this->request->getData());
        if ($this->Users->save($profile)) {
            $this->set([
                'success' => true,
                'message' => 'プロフィールを変更しました',
            ]);
        } else {
            $this->set([
                'success' => false,
                'message' => 'プロフィールを変更できませんでした',
                'errors' => $profile->getErrors(),
            ]);
        }
        $this->set('_serialize', ['success', 'message', 'errors']);
    }

    public function changePassword()
    {
        $this->request->allowMethod(['patch']);

        $profile = $this->Users->get($this->Auth->user('id'));

        $validator = $this->Users->validationPasswordConfirm(new Validator());
        $validator = $this->Users->validationCurrentPassword($validator);
        $profile = $this->Users->patchEntity(
            $profile,
            $this->request->getData(),
            ['validate' => $validator]
        );
        try {
            if ($this->Users->changePassword($profile)) {
                $this->set([
                    'success' => true,
                    'message' => 'パスワードを変更しました',
                ]);
            } else {
                $this->set([
                    'success' => false,
                    'message' => 'パスワードを変更できませんでした',
                    'errors' => $profile->getErrors(),
                ]);
            }
        } catch (WrongPasswordException $e) {
            $this->set([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $profile->getErrors(),
            ]);
        }

        $this->set('_serialize', ['success', 'message', 'errors']);
    }
}
