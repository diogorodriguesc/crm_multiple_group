<?php
declare(strict_types=1);

namespace App\UseCase\Command\DeleteCustomer\Exception;

use RuntimeException;

final class CouldNotDeleteCustomerRemainingBalanceException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Could not delete customer remaining balance.');
    }
}
