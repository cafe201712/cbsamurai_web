<?php
namespace App\Test\Fixture\Controller\Api\V1\Messages;

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
            [
                // 'id' => 1,
                'api_token' => 'guest1_token',
                'nickname' => "guest1_nickname",
                'role' => 'user',
                'photo' => "guest1.jpg",
                'active' => true,
            ],
            [
                // 'id' => 2,
                'api_token' => 'cast2_token',
                'nickname' => "cast2_nickname",
                'role' => 'cast',
                'photo' => "cast2.jpg",
                'active' => true,
            ],
            [
                // 'id' => 3,
                'api_token' => 'guest3_token',
                'nickname' => "guest3_nickname",
                'role' => 'user',
                'photo' => "guest3.jpg",
                'active' => true,
            ],
        ];

        parent::init();
    }
}
