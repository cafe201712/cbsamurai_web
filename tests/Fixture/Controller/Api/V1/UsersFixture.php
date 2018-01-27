<?php
namespace App\Test\Fixture\Controller\Api\V1;

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
                // 'id' => 1,
                'email' => 'login_user@test.jp',
                'password' => $hasher->hash('12345678'),
                'role' => 'user',
                'nickname' => 'login_user',
                'photo' => 'login_user.jpg',
                'api_token' => 'previous_token',
                'active' => true,
            ],
            [
                // 'id' => 2,
                'email' => 'other_user@test.jp',
                'password' => $hasher->hash('abcdefgh'),
                'role' => 'cast',
                'api_token' => 'other_token',
                'active' => true,
            ],
        ];

        parent::init();
    }
}
