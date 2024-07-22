<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Query\GetCustomerById\Query;
use Symfony\Component\HttpFoundation\Response;

final readonly class GetCustomerByIdController extends AbstractController
{
    public function __invoke(int $id): Response
    {
        $customer = $this->commandBus->handle(new Query($id));

        if (!$customer) {
            return $this->respondWithError(
                Response::HTTP_NOT_FOUND,
                'Customer not found'
            );
        }

        return $this->respond(
            $customer,
            ['groups' => ['show_customer']],
            Response::HTTP_OK
        );
    }
}
