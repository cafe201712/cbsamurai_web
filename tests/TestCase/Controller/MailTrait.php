<?php
namespace App\Test\TestCase\Controller;

use Cake\Mailer\Email;
use App\Test\Mailer\Transport\TestableTransport;

trait MailTrait
{
    protected function setUpMailTransfer()
    {
        Email::dropTransport('default');
        Email::setConfigTransport('default', ['className' => new TestableTransport()]);

        TestableTransport::reset(); // 以前に送信したメール情報のクリア
    }
}
