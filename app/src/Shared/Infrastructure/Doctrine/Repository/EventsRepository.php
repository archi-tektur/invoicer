<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Infrastructure\Doctrine\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

class EventsRepository extends DoctrineRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);

        // todo: to be replaced with method call in service definitions
        $this->setRepository(Event::class);
    }

    public function save(Event $event): void
    {
        dump($event);
        $this->entityManager->persist($event);
        $this->entityManager->flush($event);
    }
}
