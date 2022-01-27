<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\User;

interface UserStore
{
    public function get(): User;

    public function store(User $user): void;
}
