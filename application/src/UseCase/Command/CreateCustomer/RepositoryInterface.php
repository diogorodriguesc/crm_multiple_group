<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer;

use App\Entity\Customer;

interface RepositoryInterface
{
    public function createCustomer(Command $command): Customer;
}