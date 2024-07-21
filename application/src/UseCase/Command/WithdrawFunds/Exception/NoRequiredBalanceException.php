<?php
declare(strict_types=1);

namespace App\UseCase\Command\WithdrawFunds\Exception;

use RuntimeException;

final class NoRequiredBalanceException extends RuntimeException
{
}