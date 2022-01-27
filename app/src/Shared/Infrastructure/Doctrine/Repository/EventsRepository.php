<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Infrastructure\Doctrine\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function save(Event $event): void
    {
        $this->_em->persist($event);
        $this->_em->flush($event);
    }
}
