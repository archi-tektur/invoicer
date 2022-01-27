<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\Shared\Infrastructure\Doctrine\Entity\Event;
use DateTimeImmutable;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Uuid;

class AbstractWriteModel
{
    private EventsRepository $repository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventsRepository $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function store(EventSourcedAggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->getUncommittedEvents();

        foreach ($events as $domainEvent) {
            $id = Uuid::v4();
            $occurredOn = new DateTimeImmutable('now');
            $payload = $domainEvent->toArray();

            $event = new Event($id, $domainEvent->getId(), $domainEvent::class, $payload, $occurredOn);

            // store event in event storage
            $this->repository->save($event);

            // dispatch event through the system
            $this->dispatcher->dispatch($domainEvent, $domainEvent::class);
        }
    }
}
