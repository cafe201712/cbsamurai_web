<?php
namespace App\Test\TestCase\Controller\Api\V1\ProfileController;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use App\Test\TestCase\Controller\Api\V1\ApiTrait;

/**
 * App\Controller\Api\V1\ProfileController edit Test Case
 */
class EditTest extends IntegrationTestCase
{
    use ApiTrait;

    /**
     * @var UsersTable;
     */
    protected $Users;

    protected $api_key = 'api_key_for_user';

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

        $this->setHeaders(['api_key' => $this->api_key]);
    }

    public function testEdit()
    {
        $data = [
            'email' => 'new_email@test.com',
            'nickname' => 'new_nickname',
            'introduction' => 'new_introduction',
            'birthday' => '2018-01-01',
        ];
        $expected = [
            'success' => true,
            'message' => 'プロフィールを変更しました',
        ];

        $this->patch('/api/v1/profile.json', json_encode($data));
//        debug($this->_response->body());

        $this->assertResponseOk();
        $this->assertEquals($expected, json_decode($this->_response->body(), true));

        $updated_profile = $this->Users->find()
            ->select([
                'email',
                'nickname',
                'introduction',
                'birthday',
            ])
            ->where(['api_token' => $this->api_key])
            ->first();
        $updated_profile = json_encode($updated_profile);
//        debug($updated_profile);
        $this->assertEquals(json_encode($data), $updated_profile);
    }

    public function testEditWithInvalidData()
    {
        $data = [
            'email' => 'invalid_email',
            'birthday' => 'invalid_date',
        ];

        $this->patch('/api/v1/profile.json', json_encode($data));
        $body = json_decode($this->_response->body(), true);
//        debug($this->_response);
//        debug($body);

        $this->assertResponseOk();
        $this->assertEquals(false, $body['success']);
        $this->assertEquals('プロフィールを変更できませんでした', $body['message']);
        $this->assertArrayHasKey('email', $body['errors']);
        $this->assertArrayHasKey('birthday', $body['errors']);
    }
}
