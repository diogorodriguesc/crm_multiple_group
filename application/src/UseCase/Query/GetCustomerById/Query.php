<?php
declare(strict_types=1);

namespace App\UseCase\Query\GetCustomerById;

final readonly class Query
{
    public function __construct(public int $id)
    {
    }
}