<?php
declare(strict_types=1);

namespace App\UseCase\Command\WithdrawFunds\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\WithdrawFunds\Exception\CustomerNotFoundException;
use App\UseCase\Command\WithdrawFunds\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function withdrawFunds(int $customerId, float $amount): Customer
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($customerId);

        if (!$customer instanceof Customer || !$customer->isActive()) {
            throw new CustomerNotFoundException();
        }

        $customer->withdrawFunds($amount);

        $this->entityManager->persist($customer);
        $this->entityManager->persist(
            Transaction::createWithdrawTransaction($customer, $amount)
        );
        $this->entityManager->flush();

        return $customer;
    }
}
