<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\Shared\Infrastructure\Doctrine\Repository\AbstractWriteModel;
use App\User\Domain\Repository\UserStore;
use App\User\Domain\User;
use RuntimeException;
use Symfony\Component\Uid\Uuid;

final class UserWriteModel extends AbstractWriteModel implements UserStore
{
    public function get(Uuid $id): User
    {
        $aggregate = $this->load(User::class, $id);

        if (!$aggregate instanceof User) {
            throw new RuntimeException('Aggregate type not matched.');
        }

        return $aggregate;
    }

    public function store(EventSourcedAggregateRoot $user): void
    {
        if (!$user instanceof User) {
            throw new RuntimeException('This aggregate root is not supported by this write model.');
        }

        parent::store($user);
    }
}
