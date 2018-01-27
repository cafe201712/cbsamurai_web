<?php
namespace App\Test\Fixture\Controller\Api\V1\Home;

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
            // guest5 に「永久指名」されているキャバ嬢を２人
            [
                // id => 1
                'cast_id' => 1,
                'guest_id' => 5,
            ],
            [
                // id => 2
                'cast_id' => 2,
                'guest_id' => 5,
            ],
            // cast1 を「永久指名」するユーザーを +1（guest5 を加えて計 2人）
            [
                // id => 3
                'cast_id' => 1,
                'guest_id' => 6,
            ],
        ];

        parent::init();
    }
}
