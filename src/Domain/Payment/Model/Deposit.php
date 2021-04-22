<?php

namespace Leos\Domain\Payment\Model;

use Leos\Domain\Transaction\ValueObject\TransactionState;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Deposit
 *
 * @package Leos\Domain\Payment\Model
 */
class Deposit extends AbstractTransaction
{
    public function __construct(Wallet $wallet, Money $real, DepositDetails $details)
    {
        parent::__construct(TransactionType::DEPOSIT, $wallet, $real, new Money(0, $real->currency()));
        $this->setState(TransactionState::ACTIVE);
        $this->details = $details;
    }

    public static function create(Wallet $wallet, Money $real, DepositDetails $details): self
    {
        $deposit = new self($wallet, $real, $details);

        $deposit->raiseEvent();

        return $deposit;
    }

    public function rollback(): RollbackDeposit
    {
        $this->setState(TransactionState::REVERTED);

        return new RollbackDeposit($this);
    }

    public function details(): DepositDetails
    {
        return $this->details;
    }
}
