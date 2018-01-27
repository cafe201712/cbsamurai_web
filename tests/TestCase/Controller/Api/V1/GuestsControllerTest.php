<?php
namespace App\Test\TestCase\Controller\Api\V1;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\CastsController Test Case
 */
class GuestsControllerTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * @var UsersTable;
     */
    protected $Users;
    protected $Likes;

    protected $api_key = 'api_key_token';

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Controller/Api/V1/Guests/users',
        'app.Controller/Api/V1/Guests/likes',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
        $this->Likes = TableRegistry::get('Likes');
        $this->setHeaders(['api_key' => $this->api_key]);
        Router::fullBaseUrl('http://localhost');
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
            'guest' => [
                'id' => 2,
                'nickname' => 'user_1',
                'introduction' => '自己紹介1',
                'birthday' => '2018-01-18',
                'photo' => 'user_1.jpg',
                'photoUrl' => 'http://localhost/files/Users/photo/2/user_1.jpg',
            ]
        ];

        $this->get('/api/v1/guests/2.json');
        $body = json_decode($this->_response->body(), true);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals($expected, $body);
    }

    public function testViewWithoutLiked()
    {
        $expected = [
            'success' => true,
            'guest' => [
                'id' => 2,
                'nickname' => 'user_1',
                'introduction' => '自己紹介1',
                'birthday' => '2018-01-18',
                'photo' => 'user_1.jpg',
                'photoUrl' => 'http://localhost/files/Users/photo/2/user_1.jpg',
            ]
        ];

        $this->get('/api/v1/guests/3.json');
        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseCode(404);
    }

    public function testAddTickets()
    {
        $expected = [
            'success' => true,
            'message' => 'チケットを追加しました',
            'num_of_tickets' => 60,
        ];

        $this->patch('/api/v1/guests/add_tickets/2.json');
        $body = json_decode($this->_response->body(), true);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals($expected, $body);

        $like = $this->Likes->find()->where([
            'cast_id' => 1,
            'guest_id' => 2,
        ])->firstOrFail();
//        debug($like);
        $this->assertEquals(60, $like->num_of_tickets);
    }

    public function testAddTicketsWithoutLiked()
    {
        $this->patch('/api/v1/guests/add_tickets/3.json');
        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseCode(404);
    }
}
