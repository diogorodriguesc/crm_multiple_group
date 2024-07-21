<?php
declare(strict_types=1);

namespace App\UseCase\Command\CreateCustomer\Exception;

use Exception;

class CouldNotCreateCustomerException extends Exception
{
    public function __construct()
    {
        parent::__construct('Could Not Create Customer');
    }
}