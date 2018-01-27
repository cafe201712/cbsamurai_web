<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Like;
use App\Model\Entity\Selection;
use App\Model\Table\UsersTable;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;

/**
 * Casts Controller
 *
 *
 * @method \App\Model\Entity\Cast[] paginate($object = null, array $settings = [])
 */
class CastsController extends AppController
{
    public $paginate = [
        'sortWhitelist' => [
            'id', 'nickname', 'Shops.pref', 'Shops.area', 'Shops.name',
        ],
    ];

    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow();   // ログインしていなくても見れる

        $this->loadModel('Users');
        $this->loadModel('Likes');
        $this->loadModel('Selections');
        $this->loadComponent('Search.Prg', [
            'actions' => ['index', 'list']
        ]);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if (in_array($this->request->action, ['like', 'select'])) {
            // ここではあえて、Auth のログイン制限機能を使わず、Flash メッセージでログインが必要なことを伝える
            // ログイン画面にリダイレクトされたくないので
            if (!$this->login_user) {
                $this->Flash->error('「いいね」をするにはログインする必要があります。');
                return $this->redirect($this->referer());
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$options = ['query' => $this->request->getQuery()];
		if ($this->login_user) {
			$options['guest_id'] = $this->login_user->id;
		}
        $query = $this->Users->find('unLikedCasts', $options);
        $casts = $this->paginate($query);

        $this->set(compact('casts'));
    }

    public function list()
    {
        $this->index();
    }

    /**
     * View method
     *
     * @param string|null $id Cast id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cast = $this->Users->find('casts')
            ->where(['Users.id' => $id])
            ->firstOrFail();

        $isLiked = false;
        $isSelected = false;
        if ($this->login_user) {
            // ログインしているユーザがいいね済のキャバ嬢かチェック
            $like = $this->Likes->find()
                ->where(['cast_id' => $id, 'guest_id' => $this->login_user->id])
                ->first();
            $isLiked = $like ? true : false;

            // ログインしているユーザが永久指名済のキャバ嬢かチェック
            $selection = $this->Selections->find()
                ->where(['cast_id' => $id, 'guest_id' => $this->login_user->id])
                ->first();
            $isSelected = $selection ? true : false;
        }

        $this->set(compact('cast', 'isLiked', 'isSelected'));
    }

    public function like($id = null)
    {
        if (!$this->request->is('post')) {
            return $this->redirect($this->referer());
        }

        $like = new Like();
        $like->cast_id = $id;
        $like->guest_id = $this->login_user->id;

        if ($this->Likes->save($like)) {
            $this->Flash->success('「いいね」をリクエストしました。');
            return $this->redirect(['action' => 'view', $id]);
        }

        $messages = array_values($like->getErrors());
        $first_message = array_values($messages[0])[0];

        $this->Flash->error($first_message);
        return $this->redirect($this->referer());
    }

    public function select($id = null)
    {
        if (!$this->request->is('post')) {
            return $this->redirect($this->referer());
        }

        $selection = new Selection();
        $selection->guest_id = $this->login_user->id;
        $selection->cast_id = $id;
        if ($this->Selections->save($selection)) {
            $this->Flash->success('「永久指名」をリクエストしました。');
            return $this->redirect(['action' => 'view', $id]);
        }

        $messages = array_values($selection->getErrors());
        $first_message = array_values($messages[0])[0];
        $this->Flash->error($first_message);

        return $this->redirect($this->referer());
    }
}
