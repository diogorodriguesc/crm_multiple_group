<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Command\DeleteCustomer;

use App\UseCase\Command\DeleteCustomer\Command;
use PHPUnit\Framework\TestCase;

final class CommandTest extends TestCase
{
    public function testCommand(): void
    {
        $command = new Command(1);

        self::assertEquals(1, $command->id);
    }
}
