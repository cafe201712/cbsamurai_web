<?php
namespace App\Test\Fixture\Controller\Api\V1\Profile;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class InvitationsFixture extends TestFixture
{
    public $import = ['table' => 'invitations'];

    public function init()
    {
        $this->records = [
            [
                'id' => 'uuid-1',
                'user_id' => 2,
                'name' => '古い招待状',
                'type' => 'user',
                'active' => true,
                'created' => '2017-10-01 00:00:00'
            ],
            [
                'id' => 'uuid-2',
                'user_id' => 2,
                'name' => '新しい招待状',
                'type' => 'user',
                'active' => true,
                'created' => '2017-12-01 00:00:00'
            ],
            [
                'id' => 'uuid-3',
                'user_id' => 2,
                'name' => '無効な招待状',
                'type' => 'user',
                'active' => false,
                'created' => '2017-12-31 00:00:00'
            ],
            [
                'id' => 'uuid-4',
                'user_id' => 3,
                'name' => '他の人の招待状',
                'type' => 'user',
                'active' => true,
                'created' => '2017-12-01 00:00:00'
            ],
        ];

        parent::init();
    }
}
