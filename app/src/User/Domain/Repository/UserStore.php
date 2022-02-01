<?php

declare(strict_types=1);

namespace App\User\Domain\Repository;

use App\User\Domain\User;
use Symfony\Component\Uid\Uuid;

interface UserStore
{
    public function get(Uuid $id): User;

    public function store(User $user): void;
}
