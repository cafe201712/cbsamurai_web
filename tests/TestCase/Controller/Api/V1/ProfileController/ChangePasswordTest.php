<?php
namespace App\Test\TestCase\Controller\Api\V1\ProfileController;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;
use Cake\Auth\DefaultPasswordHasher;

/**
 * App\Controller\Api\V1\ProfileController changePassword Test Case
 */
class ChangePasswordTest extends IntegrationTestCase
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
    ];

    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('Users');
        Router::fullBaseUrl('http://localhost');
    }

    public function testChangePassword()
    {
        $hasher = new DefaultPasswordHasher();
        $api_key = 'api_key_for_user';
        $new_password = '1234abcd';
        $data = [
            'current_password' => '12345678',
            'password' => $new_password,
            'password_confirm' => $new_password,
        ];
        $expected = [
            'success' => true,
            'message' => 'パスワードを変更しました',
        ];

        $this->setHeaders(['api_key' => $api_key]);
        $this->patch('/api/v1/profile/change-password.json', json_encode($data));
//        debug($this->_response->body());

        $this->assertResponseOk();
        $this->assertEquals($expected, json_decode($this->_response->body(), true));

        $updated_user = $this->Users->find()
            ->select('password')
            ->where(['api_token' => $api_key])
            ->first();
        $this->assertTrue($hasher->check($new_password, $updated_user->password));
    }

    public function testChangePasswordWithInvalidData()
    {
        $api_key = 'api_key_for_user';
        $data = [
            'current_password' => '',
            'password' => '',
            'password_confirm' => '',
        ];
        $expected = [
            'success' => true,
            'message' => 'パスワードを変更できませんでした',
        ];

        $this->setHeaders(['api_key' => $api_key]);
        $this->patch('/api/v1/profile/change-password.json', json_encode($data));
        $body = json_decode($this->_response->body(), true);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('パスワードを変更できませんでした', $body['message']);
        $this->assertArrayHasKey('current_password', $body['errors']);
        $this->assertArrayHasKey('password', $body['errors']);
        $this->assertArrayHasKey('password_confirm', $body['errors']);
    }

    public function testChangePasswordWithInvalidCurrentPassword()
    {
        $api_key = 'api_key_for_user';
        $new_password = '1234abcd';
        $data = [
            'current_password' => 'invalid_current_password',
            'password' => $new_password,
            'password_confirm' => $new_password,
        ];

        $this->setHeaders(['api_key' => $api_key]);
        $this->patch('/api/v1/profile/change-password.json', json_encode($data));
        $body = json_decode($this->_response->body(), true);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('現在のパスワードが一致していません。', $body['message']);
    }

    public function testChangePasswordWithInvalidConfirmPassword()
    {
        $api_key = 'api_key_for_user';
        $data = [
            'current_password' => '12345678',
            'password' => 'new_1234',
            'password_confirm' => 'invalid_confirm',
        ];

        $this->setHeaders(['api_key' => $api_key]);
        $this->patch('/api/v1/profile/change-password.json', json_encode($data));
        $body = json_decode($this->_response->body(), true);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('パスワードを変更できませんでした', $body['message']);
        $this->assertArrayHasKey('password', $body['errors']);
    }
}
