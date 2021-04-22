<?php

namespace Leos\Application\UseCase\Task;

use Leos\Application\UseCase\Task\Request\CreateTask;

use Leos\Domain\Task\Model\AbstractTask;
use Leos\Domain\Task\Factory\TaskFactory;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Task\Repository\TaskRepositoryInterface;

/**
 * Class CreateTaskHandler
 *
 * @package Leos\Application\UseCase\Task
 */
class CreateTaskHandler
{
    /**
     * @var TaskRepositoryInterface
     */
    private $repository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * Withdrawal constructor.
     * @param TaskRepositoryInterface $repository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        TaskRepositoryInterface $repository,
        UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateTask $request
     * @return Task
     */
    public function handle(CreateTask $request): AbstractTask
    {
        $task = TaskFactory::create(
            $this->userRepository->findOneByUuid($request->userId()),
            $request->start,
            $request->end,
            $request->details
        );

        $this->repository->save($task);

        return $task;
    }
}
