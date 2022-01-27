<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Projection;

use App\Shared\Infrastructure\Doctrine\Projector\AbstractProjector;
use App\User\Domain\Event\UserWasCreated;
use App\User\Infrastructure\Doctrine\Entity\UserEntity;
use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;

final class DoctrineUserProjectionFactory extends AbstractProjector
{
    private DoctrineUserRepository $userRepository;

    public function __construct(DoctrineUserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function applyUserWasCreated(UserWasCreated $event): void
    {
        $entity = new UserEntity(
            $event->id,
            $event->credentials->email->toString(),
            $event->credentials->hashedPassword->toString()
        );

        $this->userRepository->save($entity);
    }

    /** {@inheritDoc} */
    public static function getHandledEventsList(): array
    {
        return [UserWasCreated::class];
    }
}
