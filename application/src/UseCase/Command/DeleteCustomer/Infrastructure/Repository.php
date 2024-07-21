<?php
declare(strict_types=1);

namespace App\UseCase\Command\DeleteCustomer\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\DeleteCustomer\Exception\CouldNotDeleteCustomerRemainingBalanceException;
use App\UseCase\Command\DeleteCustomer\Exception\CustomerNotFoundException;
use App\UseCase\Command\DeleteCustomer\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function deleteCustomer(int $id): bool
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($id);

        if (null === $customer) {
            throw new CustomerNotFoundException();
        }

        if (!$customer->hasNoBalance()) {
            throw new CouldNotDeleteCustomerRemainingBalanceException();
        }

        try {
            $this->entityManager->persist($customer->cancelCustomer());
            $this->entityManager->persist(
                Transaction::createDeletionTransaction($customer)
            );
            $this->entityManager->flush();
        } catch (Throwable) {
            return false;
        }

        return true;
    }
}
