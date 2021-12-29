<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Domain\Repository\UserStore;
use App\User\Domain\User;

final class UserWriteModel implements UserStore
{
    public function get(): User
    {
        // TODO: Implement get() method.
    }

    public function store(User $user): void
    {
        // TODO: Implement store() method.
    }
}
