<?php
namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Shops Controller
 *
 * @property \App\Model\Table\ShopsTable $Shops
 *
 * @method \App\Model\Entity\Shop[] paginate($object = null, array $settings = [])
 */
class ShopsController extends AppController
{
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
        $query = $this->Shops->find('search', ['search' => $this->request->getQuery()]);
        $shops = $this->paginate($query);

        $this->set(compact('shops'));
        $this->set('_serialize', ['shops']);
    }

    /**
     * View method
     *
     * @param string|null $id Shop id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shop = $this->Shops->get($id, [
            'contain' => []
        ]);

        $this->set('shop', $shop);
        $this->set('_serialize', ['shop']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shop = $this->Shops->newEntity();
        if ($this->request->is('post')) {
            $shop = $this->Shops->patchEntity($shop, $this->request->getData());
            if ($this->Shops->save($shop)) {
                $this->Flash->success('ショップを登録しました。');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('ショップを登録出来ませんでした。');
        }
        $this->set(compact('shop'));
        $this->set('_serialize', ['shop']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Shop id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shop = $this->Shops->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shop = $this->Shops->patchEntity($shop, $this->request->getData());
            if ($this->Shops->save($shop)) {
                $this->Flash->success('ショップを保存しました。');

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('ショップを登録できませんでした。');
        }
        $this->set(compact('shop'));
        $this->set('_serialize', ['shop']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Shop id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shop = $this->Shops->get($id);
        if ($this->Shops->delete($shop)) {
            $this->Flash->success('ショップを削除しました。');
        } else {
            $this->Flash->error(__('ショップを削除できませんでした。'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
