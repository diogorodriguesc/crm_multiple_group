<?php
declare(strict_types=1);

namespace App\UseCase\Command\TransferFunds\Exception;

use RuntimeException;

final class TransactionNotSucceedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Transaction was not succeed');
    }
}
