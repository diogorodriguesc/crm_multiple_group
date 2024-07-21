<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Command\WithdrawFunds;

use App\UseCase\Command\WithdrawFunds\Command;
use PHPUnit\Framework\TestCase;

final class CommandTest extends TestCase
{
    public function testCommand(): void
    {
        $command = new Command(1, 100.2);

        self::assertEquals(1, $command->customerId);
        self::assertEquals(100.2, $command->amount);
    }
}
