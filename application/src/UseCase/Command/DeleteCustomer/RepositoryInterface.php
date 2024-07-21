<?php
declare(strict_types=1);

namespace App\UseCase\Command\DeleteCustomer;

interface RepositoryInterface
{
    public function deleteCustomer(int $id): bool;
}