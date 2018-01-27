<?php
namespace App\Test\TestCase\Controller\Api\V1;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
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
        'app.Controller/Api/V1/users',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
        $this->setHeaders();
        Router::fullBaseUrl('http://localhost');
    }

    /**
     * Test login method
     *
     * 正しい email, password でユーザー情報、api_token が取得できること
     * api_token が新しく生成されること
     *
     * @return void
     */
    public function testLogin()
    {
        $data = [
            'email' => 'login_user@test.jp',
            'password' => '12345678'
        ];

        $user_before = $this->getUserByEmail('login_user@test.jp');
        $this->post('/api/v1/login.json', json_encode($data));
        $user_after = $this->getUserByEmail('login_user@test.jp');

        $this->assertResponseOk();

        // api_token が新たに生成されていること
        $this->assertNotEquals($user_before->api_token, $user_after->api_token);
//        debug($user_before->api_token);
//        debug($user_after->api_token);

        $expected = [
            'success' => true,
            'user' => [
                'id' => 1,
                'email' => 'login_user@test.jp',
                'nickname' => 'login_user',
                'thumbnailUrl' => 'http://localhost/files/Users/photo/1/thumbnail-login_user.jpg',
                'role' => 'user',
            ]
        ];
        $expected['user']['api_token'] = $user_after->api_token;
        $body = json_decode($this->_response->body(), true);
//        debug($expected);
//        debug($body);

        $this->assertEquals($expected, $body);
    }

    /**
     * Test login method with invalid email
     *
     * 不正な email の時、エラーとなること
     *
     * @return void
     */
    public function testLoginWithInvalidEmail()
    {
        $data = [
            'email' => 'invalid_email@test.jp',
            'password' => '12345678'
        ];
        $this->loginWithInvalidData($data);
    }

    /**
     * Test login method with invalid password
     *
     * 不正な password の時、エラーとなること
     *
     * @return void
     */
    public function testLoginWithInvalidPassword()
    {
        $data = [
            'mail' => 'login_user@test.jp',
            'password' => 'invalid_password'
        ];
        $this->loginWithInvalidData($data);
    }

    private function loginWithInvalidData($data)
    {
        $this->post('/api/v1/login.json', json_encode($data));

        $this->assertResponseOk();

        $expected = [
            'success' => false,
            'message' => 'メールアドレスかパスワードが間違っています'
        ];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

//        debug($this->_response->body());
//        debug($expected);
        $this->assertEquals($expected, $this->_response->body());
    }

    private function getUserByEmail($email)
    {
        return $this->Users->find()
            ->select(['id', 'email', 'password', 'role', 'api_token'])
            ->where(['email' => $email])
            ->first();
    }
}
