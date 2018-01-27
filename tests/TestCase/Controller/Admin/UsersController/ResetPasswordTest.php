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
class ResetPasswordTestTest extends IntegrationTestCase
{
    use MailTrait;

    public $fixtures = [
        'app.Controller/Admin/Users/users',
    ];

    /**
     * @var UsersTable;
     */
    protected $Users;

    public function setUp()
    {
        parent::setUp();

        $this->setUpMailTransfer();
        $this->enableCsrfToken();
        $this->Users = TableRegistry::get('Users');
    }

    public function testResetPasswordSendMail()
    {
        $to_address = 'user@email.com';
        $data = [
            'reference' => $to_address,
        ];

        $this->post('/request-reset-password', $data);
//        debug($this->_response);
        $this->assertRedirect('/login');

        $user = $this->Users->find()->where(['email' => $to_address])->firstOrFail();
        $mails = TestableTransport::sendMailLst();
        $this->assertEquals(1, count($mails));
        /** @var Email $mail */
        $mail = $mails[0];
        $this->assertEquals([$to_address => $to_address], $mail->getTo());
        $this->assertContains($user->token, $mail->message(Email::MESSAGE_TEXT));
    }
}
