<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerById\Infrastructure;

use App\UseCase\Query\GetCustomerById\RepositoryInterface;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function getCustomerById(int $id): ?Customer
    {
        return $this->entityManager->getRepository(Customer::class)->find($id);
    }
}