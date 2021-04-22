<?php

namespace Leos\Domain\Transaction\Event;

use Leos\Domain\Common\Event\AbstractEvent;
use Leos\Domain\Common\ValueObject\AggregateRootId;

class TransactionWasCreated extends AbstractEvent
{

    /**
     * @var string
     */
    private $taskId;

    /**
     * @var string
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
     * @var string
     */
    private $details;

    /**
     * @var \DateTime
     */
    private $createdAt;


    public function __construct(
        AggregateRootId $taskId,
        AggregateRootId $userId,
        \DateTime $start,
        \DateTime $end,
        string $details,
        \DateTime $createdAt
    ) {
        parent::__construct();

        $this->taskId = $taskId->__toString();
        $this->userId = $userId->__toString();
        $this->start = $start;
        $this->end = $end;
        $this->details = $details?$details:'';
        $this->createdAt = $createdAt;
    }
}
