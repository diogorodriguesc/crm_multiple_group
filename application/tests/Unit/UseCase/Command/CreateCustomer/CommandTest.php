<?php
declare(strict_types=1);

namespace App\Tests\Unit\UseCase\Command\CreateCustomer;

use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CommandTest extends TestCase
{
    private ?MockObject $request;
    private ?MockObject $validator;

    public function testCommand(): void
    {
        $this->request
            ->expects(self::once())
            ->method('getPayload')
            ->willReturn(
                new InputBag([
                    'name' => 'Diogo',
                    'surname' => 'Correia'
                ])
            );

        $command = Command::buildFromRequest($this->request, $this->validator);

        self::assertInstanceOf(Command::class, $command);
    }

    public function testCommandWithoutFullRequirements(): void
    {
        $this->expectException(InvalidArgumentsException::class);

        $this->request
            ->expects(self::once())
            ->method('getPayload')
            ->willReturn(
                new InputBag([
                    'name' => 'Diogo'
                ])
            );

        $this->validator
            ->expects(self::once())
            ->method('validate')
            ->willReturn(
                new ConstraintViolationList([
                        $this->createMock(ConstraintViolationInterface::class)
                    ]
                )
            );

        Command::buildFromRequest($this->request, $this->validator);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = $this->createMock(Request::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
    }
}