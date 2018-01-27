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
class MessagesControllerTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Controller/Api/V1/Messages/users',
        'app.Controller/Api/V1/Messages/messages',
        'app.Controller/Api/V1/Messages/likes',
    ];

    public function setUp()
    {
        parent::setUp();
        Router::fullBaseUrl('http://localhost');
        $this->Messages = TableRegistry::get('Messages');
        $this->Likes = TableRegistry::get('Likes');
    }

    public function testIndex()
    {
        $this->setHeaders(['api_key' => 'guest1_token']);
        $this->get('/api/v1/messages/2.json');
        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $expected_message = [
            'id' => 61,
            'body' => 'Message Body: 61',
            'from_id' => 1,
            'to_id' => 2,
            'read_at' => null,
            'created' => '2017/12/22 00:01:01',
            'modified' => null,
        ];
        $expected_user = [
            'id' => 2,
            'nickname' => 'cast2_nickname',
            'role' => 'cast',
            'photo' => 'cast2.jpg',
            'thumbnailUrl' => 'http://localhost/files/Users/photo/2/thumbnail-cast2.jpg',
        ];

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(1, $body['page']);
        $this->assertEquals(4, $body['pageCount']);
        $this->assertEquals(20, count($body['messages']));
        $this->assertEquals(61, $body['messages'][0]['id']);
        $this->assertEquals(60, $body['messages'][1]['id']);
        $this->assertEquals($expected_message, $body['messages'][0]);
        $this->assertEquals($expected_user, $body['from_user']);

        $message = $this->Messages->get(60);
        $this->assertNotNull($message->read_at);
    }

    public function testIndexPage()
    {
        $this->setHeaders(['api_key' => 'guest1_token']);
        $this->get('/api/v1/messages/2.json?page=2');
        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(2, $body['page']);
        $this->assertEquals(4, $body['pageCount']);
        $this->assertEquals(20, count($body['messages']));
        $this->assertEquals(41, $body['messages'][0]['id']);
    }

    public function testAdd()
    {
        $data = [
            'to_id' => 2,
            'body' => 'Hi Cast!!'
        ];
        $expected_data = [
            'id' => 62,
            'from_id' => 1,
            'to_id' => 2,
            'body' => 'Hi Cast!!'
        ];

        $this->setHeaders(['api_key' => 'guest1_token']);
        $this->post('/api/v1/messages', json_encode($data));

        $body = json_decode($this->_response->body(), true);
        $data = $body['data'];
//        debug($this->_response);
//        debug($body);
//        debug($data);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals('メッセージを送信しました', $body['message']);
        $this->assertEquals($expected_data['id'], $data['id']);
        $this->assertEquals($expected_data['from_id'], $data['from_id']);
        $this->assertEquals($expected_data['to_id'], $data['to_id']);
        $this->assertEquals($expected_data['body'], $data['body']);

        $saved = $this->Messages->get($body['data']['id']);
        $this->assertEquals($expected_data['from_id'], $saved->from_id);
        $this->assertEquals($expected_data['to_id'], $saved->to_id);
        $this->assertEquals($expected_data['body'], $saved->body);

        $like = $this->Likes->find()
            ->where(['guest_id' => $data['from_id'], 'cast_id' => $data['to_id']])
            ->firstOrFail();
        $this->assertEquals(49, $like->num_of_tickets);
    }

    public function testAddWithInvalidData()
    {
        $data = [
        ];

        $this->setHeaders(['api_key' => 'guest1_token']);
        $this->post('/api/v1/messages', json_encode($data));

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('メッセージを送信できませんでした', $body['message']);
        $this->assertArrayHasKey('to_id', $body['errors']);
        $this->assertArrayHasKey('body', $body['errors']);

        $count = $this->Messages->find()->count();
        $this->assertEquals(61, $count);
    }


    /**
     * チケット残がないユーザーからのメッセージ送信がエラーとなること
     */
    public function testAddNoTickets()
    {
        $data = [
            'to_id' => 2,
            'body' => 'Hi Cast!!'
        ];

        $this->setHeaders(['api_key' => 'guest3_token']);
        $this->post('/api/v1/messages', json_encode($data));

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('メッセージを送信できませんでした', $body['message']);
        $this->assertArrayHasKey('body', $body['errors']);

        $count = $this->Messages->find()->count();
        $this->assertEquals(61, $count);
    }

    public function testUnreadCount()
    {
        $this->setHeaders(['api_key' => 'guest1_token']);
        $this->get('/api/v1/messages/unread-count');

        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(true, $body['success']);
        $this->assertEquals(60, $body['count']);
    }
}
