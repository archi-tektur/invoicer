<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\Shared\Infrastructure\Doctrine\Repository\DoctrineRepository;
use App\User\Infrastructure\Doctrine\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

final class DoctrineUserRepository extends DoctrineRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        // todo: to be replaced with method call in service definitions
        $this->setRepository(UserEntity::class);
    }

    public function save(UserEntity $user): void
    {
        $this->register($user);
    }

    public function getOneById(Uuid $id): UserEntity|null
    {
        return $this->repository->find($id);
    }
}
