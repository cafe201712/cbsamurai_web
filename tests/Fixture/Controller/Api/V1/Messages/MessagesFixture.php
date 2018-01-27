<?php
namespace App\Test\Fixture\Controller\Api\V1\Messages;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\I18n\Time;

/**
 * UsersFixture
 *
 */
class MessagesFixture extends TestFixture
{
    public $import = ['table' => 'messages'];

    public function init()
    {
        $created =  Time::parse('2017-12-22 00:00:00');

        for ($i = 1; $i <= 60; $i++) {
            // message from CAST2 to USER1
            $this->records[] = [
                // id => $i
                'body' => "Message Body: ${i}",
                'from_id' => 2,
                'to_id' => 1,
                'created' => $created->addSecond()->format('Y-m-d H:i:s'),
            ];
        }

        // message from USER1 to CAST2
        $this->records[] = [
            // id => $i
            'body' => "Message Body: ${i}",
            'from_id' => 1,
            'to_id' => 2,
            'created' => $created->addSecond()->format('Y-m-d H:i:s'),
        ];

        parent::init();
    }
}
