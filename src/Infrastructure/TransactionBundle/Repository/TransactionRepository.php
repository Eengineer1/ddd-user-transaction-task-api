<?php

namespace Leos\Infrastructure\TransactionBundle\Repository;

use Leos\Domain\Transaction\Exception\TransactionNotFoundException;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Infrastructure\CommonBundle\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class TransactionRepository
 * 
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    /**
     * @param TransactionId $transactionId
     *
     * @return AbstractTransaction
     *
     * @throws TransactionNotFoundException
     */
    public function get(TransactionId $transactionId): AbstractTransaction
    {
        $transaction = $this->createQueryBuilder('transaction')
            ->where('transaction.uuid = :id')
            ->setParameter('id', $transactionId->bytes())
            ->getQuery()
            ->getOneOrNullResult()
        ;

        if (!$transaction) {

            throw new TransactionNotFoundException();
        }

        return $transaction;
    }

    public function save(AbstractTransaction $transaction): void
    {
        $this->_em->persist($transaction);
    }
}
