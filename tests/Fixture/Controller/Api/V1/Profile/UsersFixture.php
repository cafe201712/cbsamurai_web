<?php
namespace App\Test\Fixture\Controller\Api\V1\Profile;

use Cake\TestSuite\Fixture\TestFixture;
use Cake\Auth\DefaultPasswordHasher;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{
    public $import = ['table' => 'users'];

    public function init()
    {
        $hasher = new DefaultPasswordHasher();

        $this->records = [
            [
                // id => 1
                'nickname' => 'API_USER',
                'email' => 'api_user@test.jp',
                'introduction' => 'よろしくおねがいします',
                'birthday' => '2017-12-05 00:00:00',
                'photo' => 'photo_filename.jpg',
                'api_token' => 'api_key_for_user',
                'role' => 'user',
                'active' => true,
                'password' => $hasher->hash('12345678'),
            ],
            [
                // id => 2
                'nickname' => 'API_CAST',
                'email' => 'api_cast@test.jp',
                'introduction' => 'よろしくおねがいします',
                'birthday' => '2017-12-05 00:00:00',
                'photo' => 'photo_filename.jpg',
                'api_token' => 'api_key_for_cast',
                'role' => 'cast',
                'active' => true,
                'password' => $hasher->hash('12345678'),
            ],
            [
                // id => 3
                'nickname' => 'OTHER_USER',
                'email' => 'other_user@test.jp',
                'introduction' => 'Hi',
                'birthday' => '2017-11-31 00:00:00',
                'photo' => 'other_filename.jpg',
                'api_token' => 'api_key_for_other',
                'role' => 'cast',
                'active' => true,
                'password' => $hasher->hash('12345678'),
            ],
        ];

        parent::init();
    }
}
