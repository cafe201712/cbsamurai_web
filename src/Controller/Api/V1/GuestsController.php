<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * Guest Controller
 *
 *
 * @method \App\Model\Entity\Cast[] paginate($object = null, array $settings = [])
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
        // 自分を「いいね」しているユーザーかどうかの存在チェック
        $like = $this->Likes->find()->where([
            'guest_id' => $id,
            'cast_id' => $this->Auth->user('id')
        ])->firstOrFail();  // 存在しないときは、404 エラーがここで帰る

        $guest = $this->Users->find('guests')
            ->where(['id' => $id])
            ->firstOrFail();
        $guest->virtualProperties(['photoUrl']);

        $this->set([
            'success' => true,
            'guest' => $guest
        ]);
        $this->set('_serialize', ['success', 'guest']);
    }

    public function addTickets($id = null)
    {
        $this->request->allowMethod(['patch']);

        $like = $this->Likes->find()->where([
            'guest_id' => $id,
            'cast_id' => $this->Auth->user('id')
        ])->firstOrFail();

        $add_tickets = Configure::read('AppLocal.add_tickets') ?: 0;
        $like->num_of_tickets += $add_tickets;

        if ($this->Likes->save($like)) {
            $this->set([
                'success' => true,
                'message' => 'チケットを追加しました',
                'num_of_tickets' => $like->num_of_tickets
            ]);
        } else {
            $this->set([
                'success' => false,
                'message' => 'チケットを追加できませんでした',
                'errors' => $like->getErrors(),
            ]);
        }
        $this->set('_serialize', ['success', 'message', 'num_of_tickets', 'errors']);
    }
}
