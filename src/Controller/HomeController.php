<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Home Controller
 *
 *
 * @method \App\Model\Entity\Home[] paginate($object = null, array $settings = [])
 */
class HomeController extends AppController
{

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Likes');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        // スーパーユーザーとショップ管理者のホームは別 URL へリダイレクトする
        if ($this->login_user->isSuperUser() or $this->login_user->isManager()) {
            $this->redirect([
                'prefix' => 'admin',
                'controller' => 'Users',
                'action' => 'index',
            ]);
        }

        $login_user_id = $this->login_user->id;
        if ($this->login_user->isCast()) {
            // 永久指名しているユーザーの一覧を取得
            $selections = $this->Likes
                ->find('selectingGuests', ['cast_id' => $login_user_id])
                ->all();
            // いいねしているユーザーの一覧を取得
            $likes = $this->Likes
                ->find('likingGuests', ['cast_id' => $login_user_id])
                ->all();
        } else {
            // 永久指名されているキャバ嬢の一覧を取得
            $selections = $this->Likes
                ->find('selectedCasts', ['guest_id' => $login_user_id])
                ->all();
            // いいねされているキャバ嬢の一覧取得
            $likes = $this->Likes
                ->find('likedCasts', ['guest_id' => $login_user_id])
                ->all();
        }

        $this->set(compact('likes', 'selections'));
    }
}
