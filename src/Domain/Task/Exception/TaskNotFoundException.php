<?php

namespace Leos\Domain\Task\Exception;

use Leos\Domain\Common\Exception\NotFoundException;

/**
 * Class TaskNotFoundException
 *
 * @package Leos\Domain\Task\Exception
 */
class TaskNotFoundException extends NotFoundException
{

    /**
     * TaskNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('task.exception.not_found', 6004);
    }
}
