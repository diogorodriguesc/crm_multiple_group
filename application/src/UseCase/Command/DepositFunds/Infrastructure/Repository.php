<?php
declare(strict_types=1);

namespace App\UseCase\Command\DepositFunds\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\DepositFunds\Exception\CustomerNotFoundException;
use App\UseCase\Command\DepositFunds\RepositoryInterface;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function depositFunds(int $customerId, float $amount): Customer
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($customerId);

        if (!$customer instanceof Customer || !$customer->isActive()) {
            throw new CustomerNotFoundException();
        }

        $customer
            ->depositFunds($amount)
            ->setUpdatedAt(new DateTime());

        $this->entityManager->beginTransaction();

        try {
            $this->entityManager->persist($customer);
            $this->entityManager->persist(Transaction::createDepositTransaction($customer, $amount));

            $this->entityManager->flush();
            $this->entityManager->commit();
        } catch (Throwable) {
            $this->entityManager->rollback();
        }

        return $customer;
    }
}
