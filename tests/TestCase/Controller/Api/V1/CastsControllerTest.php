<?php
namespace App\Test\TestCase\Controller\Api\V1;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\CastsController Test Case
 */
class CastsControllerTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * @var UsersTable;
     */
    protected $Users;

    protected $api_key = 'api_key_token';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Controller/Api/V1/Casts/users',
        'app.Controller/Api/V1/Casts/shops',
        'app.Controller/Api/V1/Casts/likes',
        'app.Controller/Api/V1/Casts/selections',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
        $this->setHeaders(['api_key' => $this->api_key]);
        Router::fullBaseUrl('http://localhost');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $expected = [   // 先頭のデータ
            'id' => 1,
            'shop_id' => 1,
            'nickname' => 'nickname_1',
            'photo' => 'photo_1.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/1/thumbnail-photo_1.jpg',
            'shop' => [
                'name' => 'ショップ1',
                'pref' => '東京都',
                'area' => '新宿',
            ]
        ];

        $this->get('/api/v1/casts.json');
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(1, $body['page']);
        $this->assertEquals(5, $body['pageCount']);
        $this->assertEquals(20, count($body['casts'])); // ページネーションされた件数
        $this->assertEquals($expected, $body['casts'][0]);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexPaginate()
    {
        $expected = [   // 2ページ目の先頭のデータ
            'id' => 21,
            'shop_id' => 1,
            'nickname' => 'nickname_21',
            'photo' => 'photo_21.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/21/thumbnail-photo_21.jpg',
            'shop' => [
                'name' => 'ショップ1',
                'pref' => '東京都',
                'area' => '新宿',
            ]
        ];

        $this->get('/api/v1/casts.json?page=2');
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, $body['page']);
        $this->assertEquals(5, $body['pageCount']);
        $this->assertEquals(20, count($body['casts'])); // ページネーションされた件数
        $this->assertEquals($expected, $body['casts'][0]);
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $expected = [
            'success' => true,
            'cast' => [
                'id' => 1,
                'shop_id' => 1,
                'nickname' => 'nickname_1',
                'introduction' => '自己紹介',
                'birthday' => '2017-12-11',
                'photo' => 'photo_1.jpg',
                'photoUrl' => 'http://localhost/files/Users/photo/1/photo_1.jpg',
                'isLiked' => false,
                'isSelected' => false,
                'shop' => [
                    'name' => 'ショップ1',
                    'pref' => '東京都',
                    'address1' => '住所1',
                    'address2' => '住所2',
                    'tel' => '000-000-0000',
                    'fax' => '999-999-9999',
                    'address' => '東京都 住所1 住所2',
                    'description' => '素敵なお店です',
                ]
            ]
        ];

        $this->get('/api/v1/casts/1.json');
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals($expected, $body);
    }

    public function testViewLikedCast()
    {
        $this->get('/api/v1/casts/102.json');    // 「いいね」されているキャバ嬢
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['cast']['isLiked']);
        $this->assertEquals(false, $body['cast']['isSelected']);
    }

    public function testViewSelectedCast()
    {
        $this->get('/api/v1/casts/103.json');    // 「いいね」と「永久指名」されているキャバ嬢
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['cast']['isLiked']);
        $this->assertEquals(true, $body['cast']['isSelected']);
    }

    /**
     * Test like method
     *
     * @return void
     */
    public function testLike()
    {
        $expected = [
            'success' => true,
            'message' => '「いいね」しました',
        ];

        $this->post('/api/v1/casts/like/1.json');
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals($expected, $body);

        $this->Likes = TableRegistry::get('Likes');
        $count = $this->Likes->find()->where(['cast_id' => 1])->count();
        $this->assertEquals(1, $count);
    }

    /**
     * Test select method
     *
     * @return void
     */
    public function testSelect()
    {
        $expected = [
            'success' => true,
            'message' => '永久指名しました',
        ];

        $this->post('/api/v1/casts/select/1.json');
        $body = json_decode($this->_response->body(), true);

        $this->assertResponseOk();
        $this->assertEquals($expected, $body);

        $this->Selections = TableRegistry::get('Selections');
        $count = $this->Selections->find()->where(['cast_id' => 1])->count();
        $this->assertEquals(1, $count);
    }
}
