<?php
namespace App\Test\Fixture\Controller\Api\V1\Home;

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
            // guest5 に「いいね」されているキャバ嬢を４人
            [
                // id => 1
                'cast_id' => 1,
                'guest_id' => 5,
                'num_of_tickets' => 51,
            ],
            [
                // id => 2
                'cast_id' => 2,
                'guest_id' => 5,
                'num_of_tickets' => 52,
            ],
            [
                // id => 3
                'cast_id' => 3,
                'guest_id' => 5,
                'num_of_tickets' => 53,
            ],
            [
                // id => 4
                'cast_id' => 4,
                'guest_id' => 5,
                'num_of_tickets' => 54,
            ],
            // cast1 を「いいね」しているユーザーを +3人（guest5 を加えて計4人）
            [
                // id => 5
                'cast_id' => 1,
                'guest_id' => 6,
                'num_of_tickets' => 55,
            ],
            [
                // id => 6
                'cast_id' => 1,
                'guest_id' => 7,
                'num_of_tickets' => 56,
            ],
            [
                // id => 7
                'cast_id' => 1,
                'guest_id' => 8,
                'num_of_tickets' => 57,
            ],
        ];

        parent::init();
    }
}
