<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\UpdateCustomer\Command;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final readonly class UpdateCustomerByIdController extends AbstractController
{
    public function __invoke__(int $id, Request $request): Response
    {
        return $this->respond(
            $this->commandBus->handle(Command::buildFromRequest($id, $request)),
            ['groups' => ['show_customer']],
            Response::HTTP_OK
        );
    }
}
