<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Controller\Input;

use App\Shared\Infrastructure\Request\Autoresolvable;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateUserInput implements Autoresolvable
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8)]
    public string $password;
}
