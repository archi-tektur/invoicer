<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Repository;

use App\User\Infrastructure\Doctrine\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

final class DoctrineUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    public function save(UserEntity $user): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function findOneById(Uuid $id): UserEntity|null
    {
        return $this->find($id);
    }
}
