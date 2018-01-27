<?php
namespace App\Test\TestCase\Controller\Api\V1\ProfileController;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\ProfileController view Test Case
 */
class ViewTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * @var UsersTable;
     */
    protected $Users;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Controller/Api/V1/Profile/users',
        'app.Controller/Api/V1/Profile/invitations',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
        Router::fullBaseUrl('http://localhost');
    }

    /**
     * Test view method
     *
     * api_token で認証したユーザーのプロフィールが取得できること
     *
     * @return void
     */
    public function testView()
    {
        $this->setHeaders(['api_key' => 'api_key_for_user']);
        $this->get('/api/v1/profile.json');

        $this->assertResponseOk();

        $expected = [
            'success' => true,
            'profile' => [
                'id' => 1,
                'nickname' => 'API_USER',
                'email' => 'api_user@test.jp',
                'introduction' => 'よろしくおねがいします',
                'birthday' => '2017-12-05',
                'photo' => 'photo_filename.jpg',
                'photoUrl' => 'http://localhost/files/Users/photo/1/photo_filename.jpg',
                'thumbnailUrl' => 'http://localhost/files/Users/photo/1/thumbnail-photo_filename.jpg',
            ]
        ];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);
//        debug($expected);
//        debug($this->_response->body());

        $this->assertEquals($expected, $this->_response->body());
    }

    /**
     * Test view method with invitation
     *
     * 招待状を持つユーザの時、作成日が最新の招待状が取得できること
     *
     * @return void
     */
    public function testViewWithInvitation()
    {
        $this->setHeaders(['api_key' => 'api_key_for_cast']);
        $this->get('/api/v1/profile.json');

        $this->assertResponseOk();

        $expected_invitation = [
            'id' => 'uuid-2',
            'user_id' => 2,
            'name' => '新しい招待状',
            'type' => 'user',
            'active' => true,
            'url' => 'http://localhost/r?i=uuid-2',
        ];
        $result = json_decode($this->_response->body(), true);
//        debug($expected_invitation);
//        debug($result);

        $this->assertEquals(2, $result['profile']['id']);
        $this->assertEquals($expected_invitation, $result['invitation']);
        $this->assertArrayHasKey('qrcode', $result);
        $this->assertContains('<svg xmlns', $result['qrcode']);
    }

    /**
     * Test view method with invalid api_key
     *
     * 不正な api_key の時、403 エラーが返ってくること
     *
     * @return void
     */
    public function testViewWithInvalidApiToken()
    {
        $this->setHeaders(['api_key' => 'invalid_api_key']);
        $this->get('/api/v1/profile.json');

//        debug($this->_response);
        $this->assertEquals(403, $this->_response->getStatusCode());
        $this->assertEquals('', $this->_response->body());
    }
}
