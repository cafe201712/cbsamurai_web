<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Form\ContactForm;
use Cake\Core\Configure;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Auth->allow();   // ログインしていなくても見れる
    }

    /**
     * コンタクトフォーム
     */
    public function index()
    {
        $contact = new ContactForm();

        if ($this->request->is('post')) {
            if ($contact->execute($this->request->getData())) { // メール送信
                $this->Flash->success('お問い合わせを受け付けました。');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('お問合わせの送信でエラーがあります。');
            }
        }

        $this->set('contact', $contact);
        $this->render('contact');
    }
}
