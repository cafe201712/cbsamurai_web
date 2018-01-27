<?php
namespace App\Test\Fixture\Controller\Api\V1\Casts;

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
                'address1' => '住所1',
                'address2' => '住所2',
                'tel' => '000-000-0000',
                'fax' => '999-999-9999',
                'description' => '素敵なお店です',
            ],
        ];

        parent::init();
    }
}
