<?php
declare(strict_types=1);

namespace App\UseCase\Command\DepositFunds\Exception;

use RuntimeException;

final class CustomerNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Customer not found');
    }
}
