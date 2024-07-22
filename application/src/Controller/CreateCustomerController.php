<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\CreateCustomer\Command;
use App\UseCase\Command\CreateCustomer\Exception\InvalidArgumentsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class CreateCustomerController extends AbstractController
{
    public function __invoke(Request $request, ValidatorInterface $validator): Response
    {
        try {
            return $this->respond(
                $this->commandBus->handle(Command::buildFromRequest($request, $validator)),
                ['groups' => ['show_customer']],
                Response::HTTP_CREATED
            );
        } catch (InvalidArgumentsException $e) {
            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage(),
                ['fields' => $e->getErrorFields()]
            );
        }
    }
}