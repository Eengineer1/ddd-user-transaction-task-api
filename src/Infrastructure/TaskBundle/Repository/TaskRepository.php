<?php

namespace Leos\Infrastructure\TaskBundle\Repository;

use Leos\Domain\Task\Exception\TaskNotFoundException;
use Leos\Domain\Task\Model\AbstractTask;
use Leos\Domain\Task\Repository\TaskRepositoryInterface;

use Leos\Domain\Task\ValueObject\TaskId;
use Leos\Infrastructure\CommonBundle\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class TaskRepository
 * 
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    /**
     * @param TaskId $taskId
     *
     * @return AbstractTask
     *
     * @throws TaskNotFoundException
     */
    public function get(TaskId $taskId): AbstractTask
    {
        $task = $this->createQueryBuilder('task')
            ->where('task.uuid = :id')
            ->setParameter('id', $taskId->bytes())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (!$task) {

            throw new TaskNotFoundException();
        }

        return $task;
    }

    public function save(AbstractTask $task): void
    {
        $this->_em->persist($task);
    }

    public function findOneById(TaskId $uid): ?Task
    {
        return $this->createQueryBuilder('task')
            ->where('task.uuid = :id')
            ->setParameter('id', $uid->bytes())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param array $filters
     * @param array $operators
     * @param array $values
     * @param array $sort
     * @return \Pagerfanta\Pagerfanta|Task[]
     */
    public function findAll(array $filters = [], array $operators = [], array $values = [], array $sort = [])
    {
        $queryBuilder = $this->createQueryBuilder($alias = 'task');

        return $this->createOperatorPaginator($queryBuilder, $alias, $filters, $operators, $values, $sort);
    }
}
