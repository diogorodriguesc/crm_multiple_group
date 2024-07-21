<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds;

final readonly class Command
{
    public function __construct(public int $sourceCustomerId, public int $destinationCustomerId, public float $funds)
    {
    }
}
