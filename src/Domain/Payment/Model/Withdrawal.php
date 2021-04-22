<?php

namespace Leos\Domain\Payment\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;
use Leos\Domain\Transaction\ValueObject\TransactionState;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Withdrawal
 *
 * @package Leos\Domain\Payment\Model
 */
class Withdrawal extends AbstractTransaction
{
    public function __construct(Wallet $wallet, Money $real, WithdrawalDetails $details)
    {
        parent::__construct(TransactionType::WITHDRAWAL, $wallet, $real, new Money(0, $real->currency()));
        $this->setState(TransactionState::ACTIVE);
        $this->details = $details;
    }

    public static function create(Wallet $wallet, Money $real, WithdrawalDetails $details): self
    {
        $withdrawal = new self($wallet, $real, $details);

        $withdrawal->raiseEvent();

        return $withdrawal;
    }

    public function rollback(): RollbackWithdrawal
    {
        $this->setState(TransactionState::REVERTED);

        return new RollbackWithdrawal($this);
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
