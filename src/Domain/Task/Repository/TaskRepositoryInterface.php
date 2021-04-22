<?php

namespace Leos\Domain\Task\Repository;

use Leos\Domain\Task\Model\AbstractTask;
use Leos\Domain\Task\ValueObject\TaskId;
use Leos\Domain\Task\Exception\TaskNotFoundException;

/**
 * Interface TaskRepository
 *
 * @package Leos\Domain\Task\Repository
 */
interface TaskRepositoryInterface
{

    /**
     * @param TaskId $taskId
     *
     * @return AbstractTask
     *
     * @throws TaskNotFoundException
     */
    public function get(TaskId $taskId): AbstractTask;

    public function save(AbstractTask $task): void;
}
