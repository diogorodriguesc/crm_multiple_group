<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Command\UpdateCustomer;

use App\UseCase\Command\UpdateCustomer\Command;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;

final class CommandTest extends TestCase
{
    public function testCommand(): void
    {
        $request = $this->createMock(Request::class);

        $request
            ->expects(self::once())
            ->method('getPayload')
            ->willReturn(
                new InputBag([
                    'name' => 'Diogo',
                    'surname' => 'Correia'
                ])
            );

        $command = Command::buildFromRequest(1, $request);

        self::assertEquals(1, $command->id);
        self::assertEquals(
            ['name' => 'Diogo', 'surname' => 'Correia'],
            $command->data
        );
    }
}
