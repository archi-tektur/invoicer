<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Controller;

use App\Shared\Infrastructure\Symfony\Controller\AbstractAction;
use App\User\Application\Query\GetCurrentUserQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class GetCurrentUserAction extends AbstractAction
{
    #[Route('/api/user', name: 'api_user_get', methods: ['GET'])]
    public function __invoke(GetCurrentUserQuery $query): JsonResponse
    {
        $id = Uuid::v4();

        $query($id);

        return $this->responseBuilder()
            ->custom(Response::HTTP_CREATED)
            ->withDetails('User loaded successfully.')
            ->getJsonResponse()
        ;
    }
}
