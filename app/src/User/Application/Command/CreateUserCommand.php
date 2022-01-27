<?php

declare(strict_types=1);

namespace App\User\Application\Command;

use App\Shared\Application\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

final class CreateUserCommand implements CommandInterface
{
    public readonly Uuid $id;
    public readonly string $email;
    public readonly string $password;

    public function __construct(Uuid $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
}
