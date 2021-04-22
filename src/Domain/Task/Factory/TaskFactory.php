<?php

namespace Leos\Domain\Task\Factory;

use Leos\Domain\User\Model\User;
use Leos\Domain\Task\Model\AbstractTask;

/**
 * Class TaskFactory
 *
 * @package Leos\Domain\Task\Factory
 */
class TaskFactory extends AbstractTask
{
    public function __construct(User $user, \DateTime $start, \DateTime $end, string $details='')
    {
        parent::__construct($user,$start,$end,$details);
    }

    public static function create(User $user, \DateTime $start, \DateTime $end, string $details=''): self
    {
        $task = new self($user,$start,$end,$details);

        $task->raiseEvent();

        return $task;
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
