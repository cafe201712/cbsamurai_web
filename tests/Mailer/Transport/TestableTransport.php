<?php
namespace App\Test\Mailer\Transport;

use Cake\Mailer\Transport\DebugTransport;
use Cake\Mailer\Email;

/**
 * Class TestableTransport
 * @package Mailer\Transport
 */
class TestableTransport extends DebugTransport
{
    /** @var array 送信したメール */
    private static $mailList = [];

    /**
     * 送信済みメールをリセットします。
     */
    public static function reset()
    {
        static::$mailList = [];
    }

    /**
     *
     * @return array 送信したメールのリスト
     */
    public static function sendMailLst()
    {
        return static::$mailList;
    }

    /**
     * @inheritdoc
     */
    public function send(Email $email)
    {
        static::$mailList[] = clone $email;
        return parent::send($email);
    }
}