<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * News Controller
 *
 * @property \App\Model\Table\NewsTable $News
 *
 * @method \App\Model\Entity\News[] paginate($object = null, array $settings = [])
 */
class NewsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow();   // ログインしていなくても見れる
    }

    /**
     * View method
     *
     * @param string|null $id News id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $news = $this->News->get($id, [
            'contain' => []
        ]);

        $this->set('news', $news);
    }
}
