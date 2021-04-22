<?php

namespace Leos\Domain\Task\Exception;

/**
 * Class InvalidTaskTypeException
 * 
 * @package Leos\Domain\Task\Exception
 */
class InvalidTaskTypeException extends \Exception
{
    /**
     * InvalidTaskTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct("task.exception.invalid_type", 9006);
    }
}
