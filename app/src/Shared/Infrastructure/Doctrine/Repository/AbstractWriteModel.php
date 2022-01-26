<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\Shared\Infrastructure\Doctrine\Entity\Event;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class AbstractWriteModel
{
    private EventsRepository $repository;

    public function __construct(EventsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store(EventSourcedAggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->getUncommittedEvents();

        foreach ($events as $domainEvent) {
            $id = Uuid::v4();
            $occurredOn = new DateTimeImmutable('now');
            $payload = $domainEvent->toArray();

            $event = new Event($id, $domainEvent->getId(), $domainEvent::class, $payload, $occurredOn);

            $this->repository->save($event);
        }
    }
}
