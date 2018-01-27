<?php
namespace App\Test\Fixture\Controller\Admin\Users;

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
                'email' => 'user@email.com',
                'password' => $hasher->hash('user123'),
                'role' => 'user',
                'active' => true,
            ],
        ];

        parent::init();
    }
}
