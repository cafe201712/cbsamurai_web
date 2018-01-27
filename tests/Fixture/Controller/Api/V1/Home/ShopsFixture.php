<?php
namespace App\Test\Fixture\Controller\Api\V1\Home;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShopsFixture
 *
 */
class ShopsFixture extends TestFixture
{
    public $import = ['table' => 'shops'];

    public function init()
    {
        $this->records = [
            [
                // id => 1
                'name' => 'ショップ1',
                'pref' => '東京都',
                'area' => '新宿',
            ],
            [
                // id => 1
                'name' => 'ショップ2',
                'pref' => '東京都',
                'area' => '六本木',
            ],
        ];

        parent::init();
    }
}
