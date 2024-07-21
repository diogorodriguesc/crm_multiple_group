<?php
declare(strict_types=1);

namespace App\Entity\Exception;

use RuntimeException;

final class NoRequiredBalanceException extends RuntimeException
{
}