<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\Like;
use App\Model\Entity\Message;

/**
 * Messages Controller
 *
 * @property \App\Model\Table\MessagesTable $Messages
 *
 * @method \App\Model\Entity\Message[] paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{

    public $paginate = [
        'limit' => 10,
    ];

    public function initialize()
    {
        parent::initialize();

        $this->loadModel('Users');
        $this->loadModel('Likes');
    }

    /**
     * Index method
     *
     * @param string|null $user_id User id.
     * @return \Cake\Http\Response|void
     */
    public function index($user_id = null)
    {
        $from_user = $this->Users->get($user_id);
        $messages = $this->getMessages($user_id);
        $like = $this->getLike($user_id);
        $new_message = $this->Messages->newEntity();

        if ($this->request->is('post')) {
            // メッセージの追加
            $new_message = $this->Messages->patchEntity($new_message, $this->request->getData());
            $new_message->from_id = $this->login_user->id;
            $new_message->to_id = $user_id;

            if ($this->Messages->save($new_message, ['like' => $like])) {   // MessageTable の buildRule のチェックでチケット残をチェックする為、options に like を渡す
                if ($like !== null) {
                    $like->decrementTickets();
                    if (!$this->Likes->save($like)) {
                        $this->Flash->error('チケット残を更新できませんでした。システム管理者に連絡してください。');
                    }
                }
                $this->Flash->success('メッセージを送信しました。');

                return $this->redirect(['action' => 'index', '?' => ['page' => 'last'], $user_id]);
            }

            $this->Flash->error('メッセージを送信できませんでした。');
        }

        $this->set(compact('from_user', 'new_message', 'messages', 'like'));

        $this->Messages->updateReadAt($user_id, $this->login_user->id);  // 未読メッセージを既読に変更
    }

    /**
     * 指定されたユーザとのメッセージを取得する
     * メッセージはページネーション済のものを返す
     *
     * @param $user_id
     * @return Message[]
     */
    protected function getMessages($user_id)
    {
        // 全メッセージ取得
        $query = $this->Messages->find('ourMessages', [
            'user1_id' => $user_id,
            'user2_id' => $this->login_user->id,
        ]);

        // 最終ページ表示処理
        $settings = [];
        $page = $this->getCurrentPage(null);
        if (isset($page) and $page === 'last') {
            // page 指定が "last" の時は最終ページを表示する
            $last_page = $this->getPageCount($query);
            $this->request->query['page'] = $last_page;
            $settings['page'] = $last_page;
        }

        return $this->paginate($query, $settings);
    }

    /**
     * いいね情報を返す
     * ログインユーザーが顧客以外のときは null を返す
     *
     * @param $user_id
     * @return Like|null
     */
    protected function getLike($user_id)
    {
        $like = null;
        if ($this->login_user->isUser()) {
            $like = $this->Likes->find('all')
                ->where(['guest_id' => $this->login_user->id, 'cast_id' => $user_id])
                ->first();
        }

        return $like;
    }
}
