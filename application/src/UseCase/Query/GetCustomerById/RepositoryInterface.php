<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerById;

use App\Entity\Customer;
use Ramsey\Uuid\UuidInterface;

interface RepositoryInterface
{
    public function getCustomerById(int $id): ?Customer;
}