<?php

namespace App\UseCase\Command\WithdrawFunds;

use App\Entity\Customer;

interface RepositoryInterface
{
    public function withdrawFunds(int $customerId, float $amount): Customer;
}