<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\DeleteCustomer\Command;
use App\UseCase\Command\DeleteCustomer\Exception\CouldNotDeleteCustomerRemainingBalanceException;
use App\UseCase\Command\DeleteCustomer\Exception\CustomerNotFoundException;
use Symfony\Component\HttpFoundation\Response;

final readonly class DeleteCustomerController extends AbstractController
{
    public function __invoke__(int $id): Response
    {
        try {
            $this->commandBus->handle(new Command($id));

            return new Response('', Response::HTTP_NO_CONTENT);
        } catch (CustomerNotFoundException $e) {
            return $this->respondWithError(Response::HTTP_NOT_FOUND, $e->getMessage());
        } catch (CouldNotDeleteCustomerRemainingBalanceException $e) {
            return $this->respondWithError(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }
}