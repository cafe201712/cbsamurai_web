<?php
namespace App\Controller;

use App\Controller\AppController;
use BaconQrCode\Renderer\Image\Svg;

/**
 * Profile Controller
 *
 *
 * @method \App\Model\Entity\Profile[] paginate($object = null, array $settings = [])
 */
class ProfileController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Invitations');
    }

    /**
     * View method
     *
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view()
    {
        $profile = $this->Users->find('profile', [
            'id' => $this->login_user->id
        ])->first();

        $invitation = $this->Invitations->find('OwnedByUser', [
            'user_id' => $this->login_user->id,
            'sort_order' => ['created' => 'DESC'],
        ])->first();

        if ($invitation) {
            // QRコードの生成
            $qrcode = $invitation->qrcode(new Svg());
            $this->set(compact('invitation', 'qrcode'));
        }

        $this->set('profile', $profile);
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $profile = $this->login_user;

        if ($this->request->is(['patch', 'put'])) {
            $profile = $this->Users->patchEntity($profile, $this->request->getData());
            if ($this->Users->save($profile)) {
                $this->Flash->success('プロフィールを保存しました。');

                return $this->redirect(['action' => 'view']);
            }
            $this->Flash->error('プロフィールを保存できませんでした。');
        }
        $this->set(compact('profile'));
    }

    /**
     * Delete method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {
        $this->request->allowMethod('delete');
        $profile = $this->login_user;

        $profile->active = false;
        if ($this->Users->save($profile)) {
            $this->Flash->info('退会しました。');

            return $this->redirect(['prefix' => 'admin', 'controller' => 'Users', 'action' => 'logout']);
        }

        $this->Flash->error('退会出来ませんでした。');
    }
}
