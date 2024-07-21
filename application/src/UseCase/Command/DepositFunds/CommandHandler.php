<?php
declare(strict_types=1);

namespace App\UseCase\Command\DepositFunds;

use App\Entity\Customer;

final readonly class CommandHandler
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function handle(Command $command): Customer
    {
        return $this->repository->depositFunds($command->customerId, $command->amount);
    }
}