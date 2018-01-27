<?php
namespace App\Test\TestCase\Controller\Api\V1;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\HomeController Test Case
 */
class HomeControllerTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Controller/Api/V1/Home/users',
        'app.Controller/Api/V1/Home/likes',
        'app.Controller/Api/V1/Home/selections',
        'app.Controller/Api/V1/Home/shops',
        'app.Controller/Api/V1/Home/messages',
    ];

    public function setUp()
    {
        parent::setUp();

        Router::fullBaseUrl('http://localhost');
    }

    /**
     * Test likedCasts method
     *
     * api_token で認証したユーザーに
     * いいねされているキャバ嬢の一覧が取得できること
     *
     * @return void
     */
    public function testLikedCasts()
    {
        $this->setHeaders(['api_key' => 'guest5_token']);
        $this->get('/api/v1/home/liked-casts.json');

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $expected = [
            'id' => 3,
            'shop_id' => 2,
            'nickname' => 'cast3_nickname',
            'photo' => 'cast3.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/3/thumbnail-cast3.jpg',
            'role' => 'cast',
            'shop' => [
                'name' => 'ショップ2',
                'pref' => '東京都',
                'area' => '六本木',
            ],
            'sent_messages' => [
                0 => [
                    'id' => 1,
                    'from_id' => 3,
                    'to_id' => 5,
                    'body' => 'cast3 -> guest5'
                ]
            ],
        ];

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, count($body['likes']));
        $this->assertEquals(3, $body['likes'][0]['cast_id']);
        $this->assertEquals(4, $body['likes'][1]['cast_id']);
        $this->assertEquals($expected, $body['likes'][0]['cast']);
    }

    /**
     * Test selectedCasts method
     *
     * api_token で認証したユーザーに
     * 永久指名されているキャバ嬢の一覧が取得できること
     *
     * @return void
     */
    public function testSelectedCasts()
    {
        $this->setHeaders(['api_key' => 'guest5_token']);
        $this->get('/api/v1/home/selected-casts.json');

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $expected = [
            'id' => 1,
            'shop_id' => 1,
            'nickname' => 'cast1_nickname',
            'photo' => 'cast1.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/1/thumbnail-cast1.jpg',
            'role' => 'cast',
            'shop' => [
                'name' => 'ショップ1',
                'pref' => '東京都',
                'area' => '新宿',
            ],
            'sent_messages' => [
                0 => [
                    'id' => 2,
                    'from_id' => 1,
                    'to_id' => 5,
                    'body' => 'cast1 -> guest5'
                ]
            ],
        ];

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, count($body['selections']));
        $this->assertEquals(1, $body['selections'][0]['cast_id']);
        $this->assertEquals(2, $body['selections'][1]['cast_id']);
        $this->assertEquals($expected, $body['selections'][0]['cast']);
    }

    /**
     * Test likingGuest method
     *
     * api_token で認証したキャバ嬢を
     * いいねしているユーザーの一覧が取得できること
     *
     * @return void
     */
    public function testLikingGuests()
    {
        $this->setHeaders(['api_key' => 'cast1_token']);
        $this->get('/api/v1/home/liking-guests.json');

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $expected = [
            'id' => 7,
            'shop_id' => null,
            'nickname' => 'guest7_nickname',
            'photo' => 'guest7.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/7/thumbnail-guest7.jpg',
            'role' => 'user',
            'sent_messages' => [],
            'sent_messages' => [
                0 => [
                    'id' => 3,
                    'from_id' => 7,
                    'to_id' => 1,
                    'body' => 'guest7 -> cast1'
                ]
            ],
        ];

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, count($body['likes']));
        $this->assertEquals(7, $body['likes'][0]['guest_id']);
        $this->assertEquals(8, $body['likes'][1]['guest_id']);
        $this->assertEquals($expected, $body['likes'][0]['guest']);
    }

    /**
     * Test selectingGuest method
     *
     * api_token で認証したキャバ嬢を
     * 永久指名しているユーザーの一覧が取得できること
     *
     * @return void
     */
    public function testSelectingGuests()
    {
        $this->setHeaders(['api_key' => 'cast1_token']);
        $this->get('/api/v1/home/selecting-guests.json');

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $expected = [
            'id' => 5,
            'shop_id' => null,
            'nickname' => 'guest5_nickname',
            'photo' => 'guest5.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/5/thumbnail-guest5.jpg',
            'role' => 'user',
            'sent_messages' => [
                0 => [
                    'id' => 4,
                    'from_id' => 5,
                    'to_id' => 1,
                    'body' => 'guest5 -> cast1'
                ]
            ],
        ];

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, count($body['selections']));
        $this->assertEquals(5, $body['selections'][0]['guest_id']);
        $this->assertEquals(6, $body['selections'][1]['guest_id']);
        $this->assertEquals($expected, $body['selections'][0]['guest']);
    }
}
