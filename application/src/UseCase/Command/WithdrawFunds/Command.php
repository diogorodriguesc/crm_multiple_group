<?php
declare(strict_types=1);

namespace App\UseCase\Command\WithdrawFunds;

final readonly class Command
{
    public function __construct(public int $customerId, public float $amount)
    {
    }
}