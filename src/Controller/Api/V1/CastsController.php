<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Model\Entity\Like;
use App\Model\Entity\Selection;

/**
 * Casts Controller
 *
 *
 * @method \App\Model\Entity\Cast[] paginate($object = null, array $settings = [])
 */
class CastsController extends AppController
{
    public $paginate = [
        'limit' => 20,
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Likes');
        $this->loadModel('Selections');
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
        $options = ['query' => $this->request->getQuery()];
        $options['guest_id'] = $this->Auth->user('id');
        $query = $this->Users->find('unLikedCasts', $options);

        $casts = $this->paginate($query);
        $casts->each(function ($cast) {
            $cast->virtualProperties(['thumbnailUrl']);
        });

        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount($query);

        $this->set([
            'success' => true,
            'page' => $currentPage,
            'pageCount' => $pageCount,
            'casts' => $casts,
        ]);
        $this->set('_serialize', ['success', 'page', 'pageCount', 'casts']);
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
        $cast->virtualProperties(['photoUrl']);
        $cast->shop->virtualProperties(['address']);

        // ログインしているユーザがいいね済のキャバ嬢かチェック
        $like = $this->Likes->find()
            ->where(['cast_id' => $id, 'guest_id' => $this->Auth->user('id')])
            ->first();
        $cast->isLiked = $like ? true : false;

        // ログインしているユーザが永久指名済のキャバ嬢かチェック
        $selection = $this->Selections->find()
            ->where(['cast_id' => $id, 'guest_id' => $this->Auth->user('id')])
            ->first();
        $cast->isSelected = $selection ? true : false;

        $this->set([
            'success' => true,
            'cast' => $cast
        ]);
        $this->set('_serialize', ['success', 'cast']);
    }

    public function like($id = null)
    {
        $this->request->allowMethod(['post']);

        $like = new Like();
        $like->cast_id = $id;
        $like->guest_id = $this->Auth->user('id');

        if ($this->Likes->save($like)) {
            $this->set([
                'success' => true,
                'message' => '「いいね」しました',
            ]);
        } else {
            $this->set([
                'success' => false,
                'message' => '「いいね」できませんでした',
                'errors' => $like->getErrors(),
            ]);
        }
        $this->set('_serialize', ['success', 'message', 'errors']);
    }

    public function select($id = null)
    {
        $this->request->allowMethod(['post']);

        $selection = new Selection();
        $selection->cast_id = $id;
        $selection->guest_id = $this->Auth->user('id');

        if ($this->Selections->save($selection)) {
            $this->set([
                'success' => true,
                'message' => '永久指名しました',
            ]);
        } else {
            $this->set([
                'success' => false,
                'message' => '永久指名できませんでした',
                'errors' => $selection->getErrors(),
            ]);
        }
        $this->set('_serialize', ['success', 'message', 'errors']);
    }
}
