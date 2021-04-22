<?php

namespace Tests\Leos\Application\UseCase\Transaction;

use DateTime;
use Lakion\ApiTestCase\JsonApiTestCase;
use Leos\Application\UseCase\Task\Request\CreateTask;
use Leos\Domain\Task\Repository\TaskRepositoryInterface;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\Repository\UserRepositoryInterface;

use Leos\Domain\Task\Model\Task;
use Leos\Domain\Task\Repository\TaskRepositoryInterface;
use Tests\Leos\Domain\User\Model\UserTest;

/**
 * Class TaskCommandTest
 */
class TaskCommandTest extends JsonApiTestCase
{
    private $fixture = [];

    public function setUp()
    {
        $this->setUpClient();

        $userRepo = self::getMockBuilder(UserRepositoryInterface::class)
            ->setMethods(['save', 'getOneByUuid', 'findOneByUuid', 'findOneByUsername']);

        $mock = $userRepo->getMock();

        $this->fixture['user'] = UserTest::create();

        $mock->method('findOneByUuid')->with((string) $this->fixture['user']->uuid())->willReturn($this->fixture['user']);

        $taskRepo = self::getMockBuilder(TaskRepositoryInterface::class)
            ->setMethods(['save', 'get', 'findOneById', 'findAll'])->getMock();

        $container = $this->client->getContainer();

        $container->set('Leos\Domain\Task\Repository\TaskRepositoryInterface', $taskRepo);
        $container->set('Leos\Domain\User\Repository\UserRepositoryInterface', $mock);
    }

    /**
     * @group functional
     */
    public function testShouldCreateNewTask()
    {
        /** @var User $user */
        $user = $this->fixture['user'];
        $result = $this->get('tactician.commandbus')->handle(new CreateTask((string) $user->uuid(), DateTime::createFromFormat('j-M-Y','14-May-2021'), DateTime::createFromFormat('j-M-Y','15-May-2021'),'Grab two eggs from the supermarket.'));

        self::assertInstanceOf(Task::class, $result);
        self::assertTrue($result->user()->uuid()->equals($user->uuid()));
    }
}