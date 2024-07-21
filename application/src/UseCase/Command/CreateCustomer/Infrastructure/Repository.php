<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\CouldNotCreateCustomerException;
use App\UseCase\Command\CreateCustomer\RepositoryInterface;
use DateTime;
use Doctrine\DBAL\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;

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

        try {
            $this->entityManager->persist($customer);

            $this->entityManager->persist(Transaction::createAccountTransaction($customer));

            $this->entityManager->flush();
        } catch (ServerException $e) {
            dump($e->getMessage());
            throw new CouldNotCreateCustomerException();
        }

        return $customer;
    }
}