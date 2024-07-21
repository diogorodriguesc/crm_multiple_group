<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerById;

use App\Entity\Customer;

final readonly class QueryHandler
{
    public function __construct(private RepositoryInterface $repository)
    {

    }

    public function handle(Query $query): ?Customer
    {
        return $this->repository->getCustomerById($query->id);
    }
}