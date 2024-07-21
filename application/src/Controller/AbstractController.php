<?php
declare(strict_types=1);

namespace App\Controller;

use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract readonly class AbstractController
{
    public function __construct(protected CommandBus $commandBus, protected SerializerInterface $serializer)
    {
    }

    protected function respond(object $object, array $context, int $responseStatus): Response
    {
        return new Response(
            $this->serialize($object, $context),
            $responseStatus,
            ['Content-Type' => 'application/json']
        );
    }

    protected function respondWithError(int $statusCode, string $message, ?array $context = null): JsonResponse
    {
        $data = [
            'message' => $message
        ];

        if (null !== $context) {
            $data['context'] = $context;
        }

        return new JsonResponse($data, $statusCode);
    }

    private function serialize(object $object, array $context): string
    {
        return $this->serializer->serialize($object, 'json', $context);
    }
}
