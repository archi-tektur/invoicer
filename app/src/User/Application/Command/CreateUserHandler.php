<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\User\Domain\Repository\UserStore;
use App\User\Domain\User;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;

class CreateUserHandler implements CommandHandlerInterface
{
    private UserStore $userStore;

    public function __construct(UserStore $userStore)
    {
        $this->userStore = $userStore;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $email = Email::fromString($command->email);
        $hashedPassword = HashedPassword::encode($command->password);
        $credentials = new Credentials($email, $hashedPassword);

        $user = new User($command->id, $credentials);

        $this->userStore->store($user);
    }
}
