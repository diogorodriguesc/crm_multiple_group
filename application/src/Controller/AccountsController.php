<?php
declare(strict_types=1);

namespace App\Controller;

use App\UseCase\Command\DepositFunds\Command as DepositFundsCommand;
use App\UseCase\Command\TransferFunds\Command as TransferFundsCommand;
use App\UseCase\Command\TransferFunds\Exception\CustomerNotFoundException;
use App\UseCase\Command\TransferFunds\Exception\TransactionNotSucceedException;
use App\UseCase\Command\WithdrawFunds\Command as WithdrawFundsCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final readonly class AccountsController extends AbstractController
{
    public function depositFunds(int $customerId, Request $request): Response
    {
        $data = $request->getPayload()->all();

        if (!isset($data['funds']) || !is_numeric($data['funds'])) {
            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                'Invalid Arguments',
                ['fields' => 'funds']
            );
        }

        return $this->respond(
            $this->commandBus->handle(new DepositFundsCommand($customerId, $data['funds'])),
            ['groups' => ['show_funds']],
            Response::HTTP_OK
        );
    }

    public function withdrawFunds(int $customerId, Request $request): Response
    {
        $data = $request->getPayload()->all();

        if (!isset($data['funds']) || !is_numeric($data['funds'])) {
            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                'Invalid Arguments',
                ['fields' => 'funds']
            );
        }

        try {
            return $this->respond(
                $this->commandBus->handle(new WithdrawFundsCommand($customerId, $data['funds'])),
                ['groups' => ['show_funds']],
                Response::HTTP_OK
            );
        } catch (Throwable $e) {
            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage()
            );
        }
    }

    public function transferFunds(Request $request): Response
    {
        $data = $request->getPayload()->all();

        if (
            !array_key_exists('from', $data) ||
            !array_key_exists('to', $data) ||
            !array_key_exists('funds', $data)
        ) {
            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                'Invalid Arguments',
                ['fields' => ['to', 'from', 'funds']]
            );
        }

        try {
            $this->commandBus->handle(new TransferFundsCommand($data['from'], $data['to'], $data['funds']));

            return new Response('', Response::HTTP_OK);
        } catch (TransactionNotSucceedException|CustomerNotFoundException $e) {

            return $this->respondWithError(
                Response::HTTP_BAD_REQUEST,
                $e->getMessage(),
            );
        }
    }
}
