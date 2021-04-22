<?php

namespace Leos\Application\UseCase\Task\Request;

use \DateTime;
use Leos\Domain\User\ValueObject\UserId;

/**
 * Class CreateTask
 * 
 * @package Leos\Application\UseCase\Task\Request
 */
class CreateTask
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var \DateTime
     */
    private $start;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var null|string
     */
    private $details;

    /**
     * @param string $userId
     * @param \DateTime $start
     * @param \DateTime $end
     * @param string $details
     */
    public function __construct(string $userId, \DateTime $start, \DateTime $end, string $details = '')
    {
        $this->userId = new UserId($userId);
        $this->start = $start;
        $this->end = $end;
        $this->details = $details;
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return \DateTime
     */
    public function start(): \DateTime
    {
        return $this->start;
    }

    /**
     * @return \DateTime
     */
    public function end(): \DateTime
    {
        return $this->end;
    }

    /**
     * @return null|string
     */
    public function details(): ?string
    {
        return $this->details;
    }

}
