<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Model\Table\UsersTable;
use Cake\Event\Event;
use Cake\Core\Configure;

//use CakeDC\Users\Controller\Traits\SimpleCrudTrait;
use CakeDC\Users\Controller\Traits\LoginTrait;
use CakeDC\Users\Controller\Traits\RegisterTrait;
use CakeDC\Users\Exception\UserAlreadyActiveException;

/**
 * Admin/Users Controller
 *
 *
 * @method \App\Model\Entity\Admin/User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    // 全メソッドをオーバーライドした為、CakeDC/Users の Trait を削除
    // use SimpleCrudTrait;

    // ユーザー登録に招待状トークンを使った処理を追加する為、継承
    use RegisterTrait;
    use LoginTrait;

    public $paginate = [
        'sortWhitelist' => [
                'id', 'nickname', 'role', 'active', 'Shops.name',
            ],
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);

        $this->Auth->allow([
            'register',
            'validateEmail',
            'login',
            'requestResetPassword',
            'resendValidationEmail',
            'resetPassword',
            'changePassword',
        ]);

        // イベントハンドラの登録
        $this->getEventManager()->on('Users.Component.UsersAuth.beforeRegister', [$this, 'beforeRegister']);
        $this->getEventManager()->on('Users.Component.UsersAuth.afterRegister', [$this, 'afterRegister']);
    }

    public function beforeRegister(Event $event)
    {
        // URL に有効な招待状のクエリストリングが付いているかチェック
        $invitation = $this->getInvitation();
        if (empty($invitation)) {
            return;
        }

        // ユーザー情報に招待状経由で登録されたことを記録
        /** @var User $user */
        $user = $event->getData('userEntity');
        $user->invitation_id = $invitation->id;

        $this->set('invitation', $invitation);
    }

    public function afterRegister(Event $event)
    {
        // URL に有効な招待状のクエリストリングが付いているかチェック
        $invitation = $this->getInvitation();
        if (empty($invitation)) {
            return;
        }

        $user = $event->getData('user');

        // キャバ嬢の登録時、役割とショップID を更新
        if ($invitation->type === 'cast') {
            $user->role = $invitation->type;        // デフォルトのユーザー登録では role が user になっている為 cast に変える
            $user->shop_id = $invitation->shop_id;  // 所属するショップID をセット

            if (!$this->Users->save($user)) {
                $this->Flash->error(sprintf(
                    "ユーザーの役割を %s にできませんでした。システム管理者にご連絡ください。",
                    $invitation->type
                ));
            }
        }

        // 顧客登録の時、招待状の発行者のキャバ嬢を「いいね」したことにする
        if ($invitation->type === 'user') {
            /** @var User $invitees */
            $invitees = $this->Users->find()    // 存在しなくてもエラーにしない為にあえて get でなく find を使う
                ->where(['id' => $invitation->user_id])
                ->contain(['LikingGuests'])
                ->first();
            if ($invitees->isCast()) {
                $invitees->liking_guests = array_merge($invitees->liking_guests, [$user]);
                if (!$this->Users->save($invitees)) {
                    $this->Flash->error('招待者への「いいね」の付与でエラーが発生しました。');
                }
            }
        }
    }

    protected function getInvitation()
    {
        $invitation_id = $this->request->getQuery('i');
        if (empty($invitation_id)) {
            return null;
        }

        return $this->loadModel('Invitations')->find()
            ->where(['id' => $invitation_id, 'active' => true])->first();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        /** @var UsersTable $table */
        $table = $this->Users;
        $query = $table->find('search', ['search' => $this->request->getQuery()])
            ->where(['Users.role !=' => 'superuser'])
            ->contain(['Shops']);
        if ($this->login_user->isManager()) {
            // manager は 自分が所属するショップの cast しか見れない
            $query->AndWhere([
                'role' => 'cast',
                'shop_id' => $this->login_user->shop_id,
            ]);
        }

        $users = $this->paginate($query);

        $this->set('users', $users);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return mixed Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        $this->set('user', $user);

        if (!$this->request->is('post')) {
            return;
        }
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if ($this->login_user->isManager()) {
            $user->role = 'cast';   // manager は cast しか登録しない
            $user->shop_id = $this->login_user->shop_id;
        }
        if ($this->Users->save($user)) {
            $this->Flash->success('ユーザーを保存しました。');

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error('ユーザーを保存できませんでした。');
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return mixed Redirects on successful edit, renders view otherwise.
     * @throws NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);

        if (!$this->request->is(['patch', 'post', 'put'])) {
            return;
        }
        $user = $this->Users->patchEntity($user, $this->request->getData());
        if ($this->Users->save($user)) {
            $this->Flash->success('ユーザーを保存しました。');

            return $this->redirect(['action' => 'index']);
        }
        $this->Flash->error('ユーザーを保存できませんでした。');
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return Response Redirects to index.
     * @throws NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->Users->delete($user)) {
            $this->Flash->success('ユーザーを削除しました。');
        } else {
            $this->Flash->success('ユーザーを削除できませんでした。');
        }

        return $this->redirect(['action' => 'index']);
    }

    public function resendValidationEmail()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->find()
                ->where(['email' => $this->request->getData('email')])
                ->firstOrFail();

            $options = ['token_expiration' => Configure::read('Users.Token.expiration')];
            try {
                $this->Users->resendValidationEmail($user, $options);

                $this->Flash->success('確認メールを再送しました。メールをご確認ください。');
                return $this->redirect(['action' => 'login']);
            } catch (UserAlreadyActiveException $e) {
                $this->Flash->error($e->getMessage());
            }
        }
    }
}
