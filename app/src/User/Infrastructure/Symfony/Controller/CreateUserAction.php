<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Controller;

use App\Shared\Infrastructure\Symfony\Controller\AbstractAction;
use App\User\Application\Command\CreateUserCommand;
use App\User\Infrastructure\Symfony\Controller\Input\CreateUserInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

final class CreateUserAction extends AbstractAction
{
    #[Route('/api/user', name: 'api_user_post', methods: ['POST'])]
    public function __invoke(CreateUserInput $input): JsonResponse
    {
        $id = Uuid::v4();

        $command = new CreateUserCommand($id, $input->email, $input->password);
        $this->do($command);

        return $this->responseBuilder()
            ->custom(Response::HTTP_CREATED)
            ->withDetails('User created successfully.')
            ->addBodyValue('id', $id->toRfc4122())
            ->getJsonResponse()
        ;
    }
}
