<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Model\Entity\User;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\Date;
use Cake\I18n\FrozenDate;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * ログインしているユーザー
     *
     * @var User
     */
	protected $login_user;

	/**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'inputTypeMap' => [
                'json' => ['json_decode', true]     // json データを $this->request->getData() で受け取れるようマッピング
            ]
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('CakeDC/Users.UsersAuth');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');

        Time::setJsonEncodeFormat('yyyy/MM/dd HH:mm:ss');
        FrozenTime::setJsonEncodeFormat('yyyy/MM/dd HH:mm:ss');
        Date::setJsonEncodeFormat('yyyy-MM-dd');
        FrozenDate::setJsonEncodeFormat('yyyy-MM-dd');
    }

	public function beforeFilter(Event $event)
	{
        // ログインユーザー情報をビューへ渡す
        if ($this->Auth and $this->Auth->user()) {
            $table = $this->loadModel('Users');
            $this->login_user = $table->get($this->Auth->user('id'), ['contain' => 'Shops']);
            $this->set('login_user', $this->login_user);
        }
	}
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    protected function getCurrentPage($default = 1)
    {
        return $this->request->getQuery('page', $default);
    }

    protected function getPageCount($query)
    {
        $count = $query->count();
        $last_page = ceil($count / (int)$this->paginate['limit']);
        return $last_page;
    }
}
