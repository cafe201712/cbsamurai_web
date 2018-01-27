<?php
namespace App\Test\Fixture\Controller\Api\V1\Home;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{
    public $import = ['table' => 'users'];

    public function init()
    {
        $this->records = [
            // Cast
            [
                // 'id' => 1,
                'shop_id' => 1,
                'email' => 'cast1@test.jp',
                'api_token' => 'cast1_token',
                'nickname' => "cast1_nickname",
                'photo' => "cast1.jpg",
                'role' => 'cast',
                'active' => true,
            ],
            [
                // 'id' => 2,
                'shop_id' => 1,
                'email' => 'cast2@test.jp',
                'api_token' => 'cast2_token',
                'nickname' => "cast2_nickname",
                'photo' => "cast2.jpg",
                'role' => 'cast',
                'active' => true,
            ],
            [
                // 'id' => 3,
                'shop_id' => 2,
                'email' => 'cast3@test.jp',
                'api_token' => 'cast3_token',
                'nickname' => "cast3_nickname",
                'photo' => "cast3.jpg",
                'role' => 'cast',
                'active' => true,
            ],
            [
                // 'id' => 4,
                'shop_id' => 2,
                'email' => 'cast4@test.jp',
                'api_token' => 'cast4_token',
                'nickname' => "cast4_nickname",
                'photo' => "cast4.jpg",
                'role' => 'cast',
                'active' => true,
            ],

            // Guest
            [
                // 'id' => 5,
                'email' => 'guest5@test.jp',
                'api_token' => 'guest5_token',
                'nickname' => "guest5_nickname",
                'photo' => "guest5.jpg",
                'role' => 'user',
                'active' => true,
            ],
            [
                // 'id' => 6,
                'email' => 'guest6@test.jp',
                'api_token' => 'guest6_token',
                'nickname' => "guest6_nickname",
                'photo' => "guest6.jpg",
                'role' => 'user',
                'active' => true,
            ],
            [
                // 'id' => 7,
                'email' => 'guest7@test.jp',
                'api_token' => 'guest7_token',
                'nickname' => "guest7_nickname",
                'photo' => "guest7.jpg",
                'role' => 'user',
                'active' => true,
            ],
            [
                // 'id' => 8,
                'email' => 'guest8@test.jp',
                'api_token' => 'guest8_token',
                'nickname' => "guest8_nickname",
                'photo' => "guest8.jpg",
                'role' => 'user',
                'active' => true,
            ],
        ];

        parent::init();
    }
}
