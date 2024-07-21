<?php
declare(strict_types=1);

namespace App\UseCase\Command\WithdrawFunds\Exception;

use RuntimeException;

final class CustomerNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Customer Not Found');
    }
}
