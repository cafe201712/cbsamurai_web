<?php
namespace App\Test\Fixture\Controller\Api\V1\Guests;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShopsFixture
 *
 */
class LikesFixture extends TestFixture
{
    public $import = ['table' => 'likes'];

    public function init()
    {
        $this->records = [
            // user_1 が auth_cast を「いいね」する
            [
                // id => 1
                'cast_id' => 1,         // auth_cast
                'guest_id' => 2,        // user_1
                'num_of_tickets' => 50,
            ],
        ];

        parent::init();
    }
}
