<?php

namespace Leos\Domain\Task\Exception;

/**
 * Class InvalidTaskStateException
 * 
 * @package Leos\Domain\Task\Exception
 */
class InvalidTaskStateException extends \Exception
{
    /**
     * InvalidTaskStateException constructor.
     */
    public function __construct()
    {
        parent::__construct("task.exception.invalid_state", 9007);
    }
}
