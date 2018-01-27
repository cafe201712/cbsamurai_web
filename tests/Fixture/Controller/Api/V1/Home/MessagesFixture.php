<?php
namespace App\Test\Fixture\Controller\Api\V1\Home;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShopsFixture
 *
 */
class MessagesFixture extends TestFixture
{
    public $import = ['table' => 'messages'];

    public function init()
    {
        $this->records = [
            [
                // id => 1
                'body' => 'cast3 -> guest5',
                'from_id' => 3,
                'to_id' => 5,
            ],
            [
                // id => 2
                'body' => 'cast1 -> guest5',
                'from_id' => 1,
                'to_id' => 5,
            ],
            [
                // id => 3
                'body' => 'guest7 -> cast1',
                'from_id' => 7,
                'to_id' => 1,
            ],
            [
                // id => 4
                'body' => 'guest5 -> cast1',
                'from_id' => 5,
                'to_id' => 1,
            ],
        ];

        parent::init();
    }
}
