<?php
namespace App\Test\TestCase\Controller\UsersController;

use App\Controller\Admin\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\Admin/UsersController Test Case
 */
class LoginTest extends IntegrationTestCase
{
    public $fixtures = [
        'app.Controller/Admin/Users/users',
    ];

    public function setUp()
    {
        parent::setUp();
        $this->enableCsrfToken();
    }

    public function testLogin()
    {
        $data = [
            'email' => 'user@email.com',
            'password' => 'user123'
        ];

        $this->post('/login', $data);
//        debug($this->_response);

        $this->assertRedirect(['prefix' => false, 'controller' => 'Home', 'action' => 'index']);
    }

    public function testLoginAsInvalidUser()
    {
        $data = [
            'email' => 'user@email.com',
            'password' => 'other123'
        ];

        $this->post('/login', $data);
//        debug($this->_response);

        $this->assertRedirect('/login');
    }
}
