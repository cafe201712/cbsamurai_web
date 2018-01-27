<?php
namespace App\Test\Fixture\Controller\Api\V1\Casts;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SelectionsFixture
 *
 */
class SelectionsFixture extends TestFixture
{
    public $import = ['table' => 'selections'];

    public function init()
    {
        $this->records = [
            [
                // id => 1
                'cast_id' => 103,
                'guest_id' => 101,
            ],
        ];

        parent::init();
    }
}
