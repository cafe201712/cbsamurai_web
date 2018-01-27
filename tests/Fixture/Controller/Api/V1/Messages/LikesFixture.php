<?php
namespace App\Test\Fixture\Controller\Api\V1\Messages;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LikesFixture
 *
 */
class LikesFixture extends TestFixture
{
    public $import = ['table' => 'likes'];

    public function init()
    {
        $this->records = [
            [
                // 'id' => 1,
                'cast_id' => 2,
                'guest_id' => 1,
                'num_of_tickets' => '50',
            ],
            [
                // 'id' => 2,
                'cast_id' => 2,
                'guest_id' => 3,
                'num_of_tickets' => '0',
            ],
        ];

        parent::init();
    }
}
