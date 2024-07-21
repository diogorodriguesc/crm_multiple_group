<?php
declare(strict_types=1);

namespace App\UseCase\Command\UpdateCustomer;

use App\Entity\Customer;

interface RepositoryInterface
{
    public function updateCustomerById(int $id, array $data): Customer;
}