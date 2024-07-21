<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds\Exception;

use RuntimeException;

final class CustomerNotFoundException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}