<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds;

use App\UseCase\Command\TransferFunds\Exception\TransactionNotSucceedException;

final readonly class CommandHandler
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function handle(Command $command): void
    {
        $operation = $this->repository->transferFunds(
            $command->sourceCustomerId,
            $command->destinationCustomerId,
            $command->funds);

        if (false === $operation) {
            throw new TransactionNotSucceedException();
        }
    }
}
