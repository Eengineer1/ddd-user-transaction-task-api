<?php

namespace Leos\Domain\Task\ValueObject;

use Leos\Domain\Task\Model\AbstractTask;

/**
 * Class TaskState
 *
 * @package Leos\Domain\Task\ValueObject
 */
class TaskState
{
    const
        TODO = 'to-do',
        INPROGRESS = 'in-progress',
        DONE = 'done',
        CANCELLED = 'cancelled'
    ;

    public static function can(AbstractTask $task, string $new): bool
    {
        $can = false;

        $current = $task->is();

        switch ($new) {

            case self::TODO:
                $can = self::canActivate($current);
                break;
            case self::INPROGRESS:
                $can = self::canWait($current);
                break;
            case self::DONE:
                $can = self::canFinish($current);
                break;
            case self::CANCELLED:
                $can = self::canCancel($current);
                break;
        }

        return $can;
    }

    private static function canActivate(string $state): bool
    {
        return $state !== static::CANCELLED;
    }

    private static function canCancel(string $state): bool
    {
        return ($state === static::TODO || $state === static::INPROGRESS);
    }

    private static function canWait(string $state): bool
    {
        return ($state === static::TODO || $state === static::DONE);
    }

    private static function canFinish(string $state): bool
    {
        return $state === static::INPROGRESS;
    }

    public static function states(): array
    {
        return [
            self::TODO,
            self::INPROGRESS,
            self::DONE,
            self::CANCELLED,
        ]
    }
}
