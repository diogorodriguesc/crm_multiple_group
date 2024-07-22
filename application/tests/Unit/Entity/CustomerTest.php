<?php
declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Customer;
use App\Entity\Exception\NoRequiredBalanceException;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCustomer(): void
    {
        $customer = $this->getCustomer();

        self::assertEquals('Diogo', $customer->name());
        self::assertEquals('Correia', $customer->surname());
        self::assertEquals('10.03', $customer->balance());

        $customer->depositFunds(9.20);
        self::assertEquals('19.23', $customer->balance());

        $customer->withdrawFunds(4.30);
        self::assertEquals('14.93', $customer->balance());
    }

    public function testCustomerWithdrawFundsThrowsExceptionWhenTransactionExceedBalance(): void
    {
        self::expectException(NoRequiredBalanceException::class);

        $customer = $this->getCustomer();

        $customer->withdrawFunds(10.05);
    }

    public function testCustomerWithdrawFundsWithNegativeValueThrowsException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Amount of funds to withdraw must be positive');

        $customer = $this->getCustomer();

        $customer->withdrawFunds(-1.00);
    }

    public function testCustomerDepositFundsWithNegativeValueThrowsException(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('Amount of funds to deposit must be positive');

        $customer = $this->getCustomer();

        $customer->depositFunds(-1.00);
    }

    private function getCustomer(): Customer
    {
        return (new Customer())
            ->setName('Diogo')
            ->setSurname('Correia')
            ->setBalance('10.03');
    }
}