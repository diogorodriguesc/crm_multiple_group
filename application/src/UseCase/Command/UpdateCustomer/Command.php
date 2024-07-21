<?php
declare(strict_types=1);

namespace App\UseCase\Command\UpdateCustomer;

use Symfony\Component\HttpFoundation\Request;

final readonly class Command
{
    private function __construct(public int $id, public array $data)
    {
    }

    public static function buildFromRequest(int $id, Request $request): self
    {
        return new self(
            $id,
            $request->getPayload()->all()
        );
    }
}
