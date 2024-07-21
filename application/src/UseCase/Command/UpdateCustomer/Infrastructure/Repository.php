<?php
declare(strict_types=1);

namespace App\UseCase\Command\UpdateCustomer\Infrastructure;

use App\Entity\Customer;
use App\UseCase\Command\UpdateCustomer\Exception\CustomerNotFoundException;
use App\UseCase\Command\UpdateCustomer\RepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function updateCustomerById(int $id, array $data): Customer
    {
        $customer = $this->getCustomerById($id);

        if (!$customer instanceof Customer) {
            throw new CustomerNotFoundException();
        }

        if (isset($data['name'])) {
            $customer->setName($data['name']);
        }

        if (isset($data['surname'])) {
            $customer->setSurname($data['surname']);
        }

        $this->entityManager->persist($customer->setUpdatedAt(new DateTime()));
        $this->entityManager->flush();

        return $customer;
    }

    private function getCustomerById(int $id): ?Customer
    {
        return $this->entityManager->getRepository(Customer::class)->find($id);
    }
}
