<?php

namespace Leos\Infrastructure\TransactionBundle\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidBinaryType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\Task\ValueObject\TaskId;

/**
 * Class TaskType
 *
 * @package Leos\Infrastructure\TaskBundle\Doctrine\Types
 */
class TaskIdType extends UuidBinaryType
{
    const TASK_ID = 'taskId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : TaskId::fromBytes($value);
    }

    /**
     * @param TaskId $value
     * @param AbstractPlatform $platform
     * @return null|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_string($value)) {

            return TaskId::toBytes($value);
        }
        
        return (null === $value) ? null : $value->bytes();
    }

    public function getName()
    {
        return self::TASK_ID;
    }
}
