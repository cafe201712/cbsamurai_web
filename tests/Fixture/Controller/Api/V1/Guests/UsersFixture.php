<?php
namespace App\Test\Fixture\Controller\Api\V1\Guests;

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
            // user for api auth
            // キャバ嬢
            [
                // id => 1
                'email' => 'auth_user@mail.com',
                'api_token' => 'api_key_token',
                'nickname' => "auth_cast",
                'photo' => "auth_cast.jpg",
                'role' => 'cast',   // キャバ嬢
                'active' => true,
            ],
            // キャバ嬢を「いいね」しているユーザー
            [
                // id => 2
                'nickname' => 'user_1',
                'introduction' => '自己紹介1',
                'birthday' => '2018-01-18',
                'photo' => 'user_1.jpg',
                'role' => 'user',
                'active' => true,
            ],
            // キャバ嬢を「いいね」していないユーザー
            [
                // id => 3
                'nickname' => 'user_2',
                'introduction' => '自己紹介2',
                'birthday' => '2018-01-18',
                'photo' => 'user_2.jpg',
                'role' => 'user',
                'active' => true,
            ],
        ];

        parent::init();
    }
}
