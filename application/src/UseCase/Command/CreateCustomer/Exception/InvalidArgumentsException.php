<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Exception;

use Exception;

final class InvalidArgumentsException extends Exception
{
    public function __construct(private readonly array $errorFields)
    {
        parent::__construct('Invalid arguments');
    }

    public function getErrorFields(): array
    {
        return $this->errorFields;
    }
}