<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\CouldNotCreateCustomerException;
use App\UseCase\Command\CreateCustomer\RepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @throws CouldNotCreateCustomerException
     */
    public function createCustomer(Command $command): Customer
    {
        $customer = new Customer();

        $customer
            ->setName($command->name)
            ->setSurname($command->surname)
            ->setCreatedAt($createdDateTime = new DateTime())
            ->setUpdatedAt($createdDateTime)
            ->setBalance('0.00');

        $this->entityManager->beginTransaction();
        try {
            $this->entityManager->persist($customer);
            $this->entityManager->persist(Transaction::createAccountTransaction($customer));
            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Throwable) {
            $this->entityManager->rollback();
            throw new CouldNotCreateCustomerException();
        }

        return $customer;
    }
}