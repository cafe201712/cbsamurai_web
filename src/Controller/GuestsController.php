<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Guests Controller
 *
 *
 * @method \App\Model\Entity\Guest[] paginate($object = null, array $settings = [])
 */
class GuestsController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Likes');
    }

    /**
     * View method
     *
     * @param string|null $id Guest id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $guest = $this->Users->find('guests')
            ->where(['id' => $id])
            ->firstOrFail();
        $like = $this->Likes->find()->where([
            'guest_id' => $id,
            'cast_id' => $this->login_user->id,
        ])->firstOrFail();

        if ($this->request->is(['patch', 'put'])) {
            $add_tickets = Configure::read('AppLocal.add_tickets') ?: 0;
            $like->num_of_tickets += $add_tickets;

            if ($this->Likes->save($like)) {
                $this->Flash->success('チケットを追加しました。');
                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error('チケットを追加できませんでした。');
        }

        $this->set(compact('guest', 'like'));
    }
}
