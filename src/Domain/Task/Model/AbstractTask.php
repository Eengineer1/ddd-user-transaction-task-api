<?php
declare(strict_types=1);

namespace Leos\Domain\Task\Model;

use DateTime;
use Leos\Domain\Common\ValueObject\AggregateRoot;
use Leos\Domain\Task\Event\TaskWasCreated;
use Leos\Domain\User\Model\User;
use Leos\Domain\Task\ValueObject\TaskId;
use Leos\Domain\Task\ValueObject\TaskState;
use Leos\Domain\Task\Exception\InvalidTaskStateException;

/**
 * Class Task
 *
 * @package Leos\Domain\Task\Model
 */
abstract class AbstractTask extends AggregateRoot
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    private $state = TaskState::TODO;

    /**
     * @var null|string
     */
    protected $details;

    /**
     * @var \DateTime
     */
    protected $start;

    /**
     * @var \DateTime
     */
    protected $end;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var null|\DateTime
     */
    protected $updatedAt;

    public function __construct(
        User $user,
        DateTime $start,
        DateTime $end,
        ?string $details
    )
    {
        parent::__construct(new TaskId());

        $this->user = $user;
        $this->start = $start;
        $this->end = $end;
        $this->details = $details;
        $this->createdAt = new \DateTime();
    }

    protected function raiseEvent(): void
    {
        $this->raise(
            new TaskWasCreated(
                $this->uuid(),
                $this->user->uuid(),
                $this->start->__toString(),
                $this->end->__toString(),
                $this->createdAt()
            )
        );
    }

    public function is(): string
    {
        return $this->state;
    }

    /**
     * @param string $newState
     *
     * @return AbstractTask
     *
     * @throws InvalidTaskStateException
     */
    final protected function setState(string $newState): self
    {
        if (!TaskState::can($this, $newState)) {

            throw new InvalidTaskStateException();
        }

        $this->state = $newState;

        return $this;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }

    /**
     * @param mixed $details
     * 
     * @return AbstractTask
     */
    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }


    public function rollback()
    {
        // Implement when need it
    }
}
