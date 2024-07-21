<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds\Infrastructure;

use App\Entity\Customer;
use App\Entity\Transaction;
use App\UseCase\Command\TransferFunds\Exception\CustomerNotFoundException;
use App\UseCase\Command\TransferFunds\RepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

final readonly class Repository implements RepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function transferFunds(int $sourceCustomerId, int $destinationCustomerId, float $funds): bool
    {
        $this->entityManager->beginTransaction();

        $sourceCustomer = $this->entityManager->getRepository(Customer::class)->find($sourceCustomerId);
        $destinationCustomer = $this->entityManager->getRepository(Customer::class)->find($destinationCustomerId);

        if (!$sourceCustomer instanceof Customer || !$sourceCustomer?->isActive()) {
            throw new CustomerNotFoundException('Source Customer not found');
        }

        if (!$destinationCustomer instanceof Customer || !$destinationCustomer?->isActive()) {
            throw new CustomerNotFoundException('Destination Customer not found');
        }

        try {
            $sourceCustomer->withdrawFunds($funds);
            $destinationCustomer->depositFunds($funds);

            $this->entityManager->persist($sourceCustomer);
            $this->entityManager->persist($destinationCustomer);
            $this->entityManager->persist(
                Transaction::createTransferTransaction($sourceCustomer, $destinationCustomer, $funds)
            );
            $this->entityManager->flush();

            $this->entityManager->commit();

            return true;
        } catch (Throwable) {
            $this->entityManager->rollback();

            return false;
        }
    }
}
