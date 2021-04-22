<?php

namespace Tests\Leos\UI\RestBundle\Controller\User;

use Lakion\ApiTestCase\JsonApiTestCase;
use Tests\Leos\UI\RestBundle\Controller\Security\SecurityTrait;

/**
 * Class UserControllerTest
 *
 * @package Leos\UI\RestBundle\Controller\User
 */
class UserControllerTest extends JsonApiTestCase
{
    use SecurityTrait;

    private $databaseLoaded = false;

    public function setUp()
    {

        if (!$this->client) {

            $this->setUpClient();
        }

        if (!$this->databaseLoaded) {

            $this->setUpDatabase();
            $this->databaseLoaded = true;
        }
    }

    /**
     * @group integration
     */
    public function testCreateUser()
    {
        $this->client->request('POST', '/auth/register', [
            'username' => 'paco',
            'email' => 'paco@gmail.com',
            'password' => 'qweqwe1234567890'
        ]);

        $response = $this->client->getResponse();

        self::assertResponse($response, "User/new_user", 201);

        $this->loginClient('paco', 'qweqwe1234567890');

        $this->client->request('GET', $response->headers->get('location'));

        $response = $this->client->getResponse();

        self::assertResponse($response, "User/new_user", 200);
    }

    /**
     * @group integration
     */
    public function testCreateUserWithWrongPassword()
    {
        $this->client->request('POST', '/auth/register', [
            'username' => 'paco',
            'email' => 'paco@gmail.com',
            'password' => 'qwe'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('password', $response->getContent());
    }

    /**
     * @group integration
     */
    public function testCreateUserWithWrongEmail()
    {
        $this->client->request('POST', '/auth/register', [
            'username' => 'paco',
            'email' => 'paco',
            'password' => 'qwe1313ghg1313'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('email', $response->getContent());
    }

    /**
     * @group integration
     */
    public function testCreateUserWithEmptyParams()
    {

        $this->client->request('POST', '/auth/register', [
            'username' => '',
            'email' => '',
            'password' => 'qwe1313ghg1313'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
    }

    /**
     * @group integration
     */
    public function testCreateUserWithWrongUsername()
    {
        $this->loadFixturesFromDirectory('user');

        $this->client->request('POST', '/auth/register', [
            'username' => 'jorge',
            'email' => 'paco@gmail.com',
            'password' => 'qwe1234567'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(409, $response->getStatusCode());
        self::assertContains('already_exist', $response->getContent());
    }

    /**
     * @group integration
     */
    public function testFindUserWithWrongUUIDFormat()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('GET', '/api/v1/user/adadadasda.json');

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('uuid', $response->getContent());
    }
    /**
     * @group integration
     */
    public function testFindUserWithNotExistingUUID()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('GET', '/api/v1/user/0cb00000-646e-11e6-a5a2-0000ac1b0000.json');

        $response = $this->client->getResponse();

        self::assertEquals(404, $response->getStatusCode());
    }
}
