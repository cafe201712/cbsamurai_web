<?php
namespace App\Controller\Admin;

use App\Controller\AppController;
use BaconQrCode\Renderer\Image\Svg;
use BaconQrCode\Renderer\Image\Png;

/**
 * Invitations Controller
 *
 * @property \App\Model\Table\InvitationsTable $Invitations
 *
 * @method \App\Model\Entity\Invitation[] paginate($object = null, array $settings = [])
 */
class InvitationsController extends AppController
{
    public $paginate = [
        'sortWhitelist' => [
			'id', 'name', 'type', 'Shops.name', 'created', 'active',
		],
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Search.Prg', [
            'actions' => ['index']
        ]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$query = $this->Invitations
            ->find('search', ['search' => $this->request->getQuery()])
            ->contain(['Shops', 'Users'])->order(['Invitations.created' => 'DESC']);
		if ($this->login_user->isManager() or $this->login_user->isCast()) {
			$query->andWhere(['Invitations.user_id' => $this->login_user->id]);
		}
        $invitations = $this->paginate($query);

        $this->set(compact('invitations'));
    }

    /**
     * View method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invitation = $this->Invitations->get($id, [
            'contain' => ['Shops', 'Users']
        ]);
        $qrcode = $invitation->qrcode(new Svg());

        $this->set(compact('invitation', 'qrcode'));
    }

    /**
     * Download QRCode
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null|static
     */
    public function download($id = null)
    {
        $invitation = $this->Invitations->get($id);

        if (!$invitation->active) {
            $this->Flash->error('無効な招待状なので、ダウンロードできません。');
            return $this->redirect(['action' => 'view', $id]);
        }

        $qrcode = $invitation->qrcode(new Png());

        $this->response->body($qrcode);
        $response = $this->response->withType('png')
                         ->withDownload('qrcode.png');
        return $response;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invitation = $this->Invitations->newEntity();

        if ($this->request->is('post')) {
            $invitation = $this->Invitations->patchEntity($invitation, $this->request->getData());
			$invitation->user_id = $this->login_user->id;
			if (!$this->login_user->isSuperUser()) {
				$invitation->shop_id = $this->login_user->shop_id;
			}

            if ($this->Invitations->save($invitation)) {
                $this->Flash->success('招待状を保存しました。');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('招待状を保存できませんでした。');
        }

        $this->set(compact('invitation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invitation = $this->Invitations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invitation = $this->Invitations->patchEntity($invitation, $this->request->getData());
            if ($this->Invitations->save($invitation)) {
                $this->Flash->success('招待状を保存しました。');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('招待状を保存できませんでした。');
        }
        $this->set(compact('invitation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invitation id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invitation = $this->Invitations->get($id);
        // TODO: 招待されて登録したユーザーがいる場合削除できないようにチェックすること
        if ($this->Invitations->delete($invitation)) {
            $this->Flash->success(__('The invitation has been deleted.'));
        } else {
            $this->Flash->error(__('The invitation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
