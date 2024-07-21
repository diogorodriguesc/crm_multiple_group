<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

use App\Entity\Customer;

final readonly class CommandHandler
{
    public function __construct(private RepositoryInterface $repository)
    {
    }

    public function handle(Command $command): Customer
    {
        return $this->repository->createCustomer($command);
    }
}