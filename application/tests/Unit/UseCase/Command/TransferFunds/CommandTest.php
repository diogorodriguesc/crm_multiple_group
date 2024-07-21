<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Command\TransferFunds;

use App\UseCase\Command\TransferFunds\Command;
use PHPUnit\Framework\TestCase;

final class CommandTest extends TestCase
{
    public function testCommand(): void
    {
        $command = new Command(1,2,100);

        self::assertEquals(1, $command->sourceCustomerId);
        self::assertEquals(2, $command->destinationCustomerId);
        self::assertEquals(100, $command->funds);
    }
}
