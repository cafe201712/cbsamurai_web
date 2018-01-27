<?php
namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Model\Entity\User;
use App\Model\Entity\Like;

/**
 * Casts Controller
 *
 *
 * @method \App\Model\Entity\Cast[] paginate($object = null, array $settings = [])
 */
class MessagesController extends AppController
{
    public $paginate = [
        'limit' => 20,
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
        $from_user = $this->Users->find()
            ->select(['id', 'nickname', 'role', 'photo'])
            ->where(['id' => $user_id])->firstOrFail();
        $from_user->virtualProperties(['thumbnailUrl']);

        $options = [
            'user1_id' => $user_id,
            'user2_id' => $this->Auth->user('id'),
        ];
        $query = $this->Messages->find('ourMessages', $options)->order(['created' => 'DESC', 'id' => 'DESC'], true);
        $messages = $this->paginate($query);

        $currentPage = $this->getCurrentPage();
        $pageCount = $this->getPageCount($query);

        $this->set([
            'success' => true,
            'from_user' => $from_user,
            'page' => $currentPage,
            'pageCount' => $pageCount,
            'messages' => $messages,
        ]);
        $this->set('_serialize', ['success', 'from_user', 'page', 'pageCount', 'messages']);

        $this->Messages->updateReadAt($user_id, $this->Auth->user('id'));  // 未読メッセージを既読に変更
    }

    public function add()
    {
        $this->request->allowMethod(['post']);

        $login_user = $this->Users->get($this->Auth->user('id'));
        $message = $this->Messages->newEntity($this->request->getData());
        $message->from_id = $login_user->id;
        $like = $this->getLike($login_user, $message->to_id);

        if ($this->Messages->save($message, ['like' => $like])) {   // MessageTable の buildRule のチェックでチケット残をチェックする為、options に like を渡す
            if ($like !== null) {
                $like->decrementTickets();
                if (!$this->Likes->save($like)) {
                    $this->log('チケット残を更新できませんでした。システム管理者に連絡してください。');   // この場合、特にユーザーにはエラーを知らせいないことにする
                }
            }
            $this->set([
                'success' => true,
                'data' => $message,
                'message' => 'メッセージを送信しました',
            ]);
        } else {
            $this->set([
                'success' => false,
                'message' => 'メッセージを送信できませんでした',
                'errors' => $message->getErrors(),
            ]);
        }
        $this->set('_serialize', ['success', 'data', 'message', 'errors']);
    }

    public function unreadCount()
    {
        $message = $this->Messages->find('unreadCount', ['to_id' => $this->Auth->user('id')])->firstOrFail();

        $this->set([
            'success' => true,
            'count' => $message->count
        ]);
        $this->set('_serialize', ['success', 'count']);
    }

    /**
     * いいね情報を返す
     * ログインユーザーが顧客以外のときは null を返す
     *
     * @param User $from_user
     * @param integer $to_id
     * @return Like | null
     */
    protected function getLike(User $from_user, $to_id)
    {
        $like = null;
        if ($from_user->isUser()) {
            $like = $this->Likes->find('all')
                ->where(['guest_id' => $from_user->id, 'cast_id' => $to_id])
                ->first();
        }

        return $like;
    }
}
