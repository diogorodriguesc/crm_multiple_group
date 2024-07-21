<?php
declare(strict_types=1);

namespace App\UseCase\Command\DeleteCustomer;

final readonly class CommandHandler
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function handle(Command $command): bool
    {
        return $this->repository->deleteCustomer($command->id);
    }
}