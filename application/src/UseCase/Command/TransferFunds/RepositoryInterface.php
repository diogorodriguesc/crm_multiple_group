<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds;

use App\Entity\Customer;

interface RepositoryInterface
{
    public function transferFunds(int $sourceCustomerId, int $destinationCustomerId, float $funds): bool;
}
