<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Symfony\Controller\Input;

use App\Shared\Infrastructure\Request\Autoresolvable;

class CreateUserInput implements Autoresolvable
{
    public string|null $name = null;
}
