<?php
declare(strict_types=1);

namespace App\UseCase\Command\DeleteCustomer;

final readonly class Command
{
    public function __construct(public int $id)
    {
    }
}