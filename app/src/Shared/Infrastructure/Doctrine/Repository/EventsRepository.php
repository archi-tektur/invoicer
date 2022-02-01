<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Infrastructure\Doctrine\Entity\EventEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventEntity::class);
    }

    public function getLastEventPlayheadByAggregateId(Uuid $aggregateId): int
    {
        /** @var EventEntity[] $lastEvent */
        $lastEvents = $this->findBy(['aggregateId' => $aggregateId], ['occurredOn' => 'DESC'], 1);

        if (count($lastEvents) < 1) {
            return -1;
        }

        $lastEvent = $lastEvents[0];

        return $lastEvent->getPlayhead();
    }

    public function save(EventEntity $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush($event);
    }
}
