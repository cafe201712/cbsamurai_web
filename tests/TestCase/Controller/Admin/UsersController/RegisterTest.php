<?php
namespace App\Test\TestCase\Controller\UsersController;

use App\Controller\Admin\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use App\Test\TestCase\Controller\MailTrait;
use App\Test\Mailer\Transport\TestableTransport;

/**
 * App\Controller\Admin/UsersController Test Case
 */
class RegisterTest extends IntegrationTestCase
{
    use MailTrait;

    public $fixtures = [
        'app.Controller/Admin/Users/users',
    ];

    /**
     * @var UsersTable;
     */
    protected $Users;
    protected $initialCount = null;

    public function setUp()
    {
        parent::setUp();

        $this->setUpMailTransfer();
        $this->enableCsrfToken();
        $this->Users = TableRegistry::get('Users');
        $this->initialCount = $this->Users->find()->count();
    }

    public function testRegister()
    {
        $data = [
            'email' => 'new_user@mail.com',
            'password' => 'user1234',
            'password_confirm' => 'user1234',
            'nickname' => 'new_nickname',
            'tos' => true,
        ];

        $this->post('/register', $data);
//        debug($this->_response);
        $this->assertRedirect('/login');

        $user = $this->Users->find()->where(['email' => 'new_user@mail.com'])->firstOrFail();
        $this->assertEquals('new_user@mail.com', $user->email);
        $this->assertEquals('user', $user->role);
        $this->assertEquals(false, $user->active);
        $this->assertEquals($this->initialCount + 1, $this->Users->find()->count());

        $mails = TestableTransport::sendMailLst();
        $this->assertEquals(1, count($mails));
        /** @var Email $mail */
        $mail = $mails[0];
        $this->assertEquals([$user->email => $user->email], $mail->getTo());
        $this->assertContains($user->token, $mail->message(Email::MESSAGE_TEXT));
    }

    public function testRegisterWithInvalidData()
    {
        $data = [
            // 必須項目が足りないデータ
        ];

        $this->post('/register', $data);
//        debug($this->_response);
//        debug($this->viewVariable('user'));

        $this->assertNoRedirect();
        $this->assertNotEmpty($this->viewVariable('user')->errors());
        $this->assertEquals($this->initialCount, $this->Users->find()->count());

        $mails = TestableTransport::sendMailLst();
        $this->assertEquals(0, count($mails));
    }
}
