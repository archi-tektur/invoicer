<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;

class CreateUserHandler implements CommandHandlerInterface
{
    public function __construct()
    {
    }

    public function __invoke(CreateUserCommand $command): void
    {
    }
}
