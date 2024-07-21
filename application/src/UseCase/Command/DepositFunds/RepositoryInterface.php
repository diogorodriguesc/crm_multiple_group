<?php

namespace App\UseCase\Command\DepositFunds;

use App\Entity\Customer;

interface RepositoryInterface
{
    public function depositFunds(int $customerId, float $amount): Customer;
}