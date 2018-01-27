<?php
namespace App\Test\Fixture\Controller\Api\V1\Casts;

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
            [
                // id => 1
                'cast_id' => 102,
                'guest_id' => 101,
            ],
            [
                // id => 2
                'cast_id' => 103,
                'guest_id' => 101,
            ],
        ];

        parent::init();
    }
}
