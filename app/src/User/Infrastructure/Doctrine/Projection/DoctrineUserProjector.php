<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projection;

use App\User\Domain\Event\UserWasCreated;
use App\User\Infrastructure\Doctrine\Entity\UserEntity;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;

final class DoctrineUserProjector
{
    private DoctrineUserRepository $repository;

    public function __construct(DoctrineUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function applyUserWasCreated(UserWasCreated $event): void
    {
        $entity = new UserEntity(
            $event->id,
            $event->credentials->email->toString(),
            $event->credentials->hashedPassword->toString()
        );

        $this->repository->save($entity);
    }
}
