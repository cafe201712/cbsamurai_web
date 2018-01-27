<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;

/**
 * Casts Controller
 *
 *
 * @method \App\Model\Entity\Cast[] paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Likes');
    }

    /**
     * いいねされているキャバ嬢の一覧取得
     */
    public function likedCasts()
    {
        $likes = $this->Likes
            ->find('likedCasts', ['guest_id' => $this->Auth->user('id')])
            ->all();
        $likes->each(function ($like) {
            $like->cast->virtualProperties(['thumbnailUrl']);
        });

        $this->set([
            'success' => true,
            'likes' => $likes,
        ]);
        $this->set('_serialize', ['success', 'likes']);
    }

    /**
     * 永久指名されているキャバ嬢の一覧取得
     */
    public function selectedCasts()
    {
        $selections = $this->Likes
            ->find('selectedCasts', ['guest_id' => $this->Auth->user('id')])
            ->all();
        $selections->each(function ($selection) {
            $selection->cast->virtualProperties(['thumbnailUrl']);
        });

        $this->set([
            'success' => true,
            'selections' => $selections,
        ]);
        $this->set('_serialize', ['success', 'selections']);
    }

    /**
     * いいねしているユーザーの一覧取得
     */
    public function likingGuests()
    {
        $likes = $this->Likes
            ->find('likingGuests', ['cast_id' => $this->Auth->user('id')])
            ->all();
        $likes->each(function ($like) {
            $like->guest->virtualProperties(['thumbnailUrl']);
        });

        $this->set([
            'success' => true,
            'likes' => $likes,
        ]);
        $this->set('_serialize', ['success', 'likes']);
    }

    /**
     * 永久指名しているユーザーの一覧取得
     */
    public function selectingGuests()
    {
        $selections = $this->Likes
            ->find('selectingGuests', ['cast_id' => $this->Auth->user('id')])
            ->all();
        $selections->each(function ($selection) {
            $selection->guest->virtualProperties(['thumbnailUrl']);
        });

        $this->set([
            'success' => true,
            'selections' => $selections,
        ]);
        $this->set('_serialize', ['success', 'selections']);
    }
}
