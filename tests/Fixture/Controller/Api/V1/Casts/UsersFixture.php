<?php
namespace App\Test\Fixture\Controller\Api\V1\Casts;

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
        $records = [];

        // casts
        for($i = 1; $i <= 100; $i++) {
            $records[] = [
                // id => $i
                'shop_id' => 1,
                'nickname' => "nickname_${i}",
                'photo' => "photo_${i}.jpg",
                'role' => 'cast',
                'active' => true,
                'introduction' => '自己紹介',
                'birthday' => '2017-12-11',
            ];
        }

        // user for api auth
        $records[] = [
            // id => 101
            'email' => 'auth_user@mail.com',
            'api_token' => 'api_key_token',
            'nickname' => "auth_nickname",
            'photo' => "auth_user.jpg",
            'role' => 'user',
            'active' => true,
        ];

        // liked cast（likes テーブルから参照されるデータ）
        $records[] = [
            // id => 102
            'shop_id' => 1,
            'nickname' => "nickname_102",
            'role' => 'cast',
            'active' => true,
        ];

        // selected cast（likes テーブルと selected テーブルから参照されるデータ）
        $records[] = [
            // id => 103
            'shop_id' => 1,
            'nickname' => "nickname_103",
            'role' => 'cast',
            'active' => true,
        ];

        $this->records = $records;

        parent::init();
    }
}
