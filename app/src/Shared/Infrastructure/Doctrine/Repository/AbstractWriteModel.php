<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\Shared\Infrastructure\Doctrine\Entity\EventEntity;
use DateTimeImmutable;
use ReflectionClass;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Uid\Uuid;

class AbstractWriteModel
{
    private EventsRepository $repository;
    private EventDispatcherInterface $dispatcher;

    public function __construct(EventsRepository $eventsRepository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $eventsRepository;
        $this->dispatcher = $dispatcher;
    }

    /** @throws \ReflectionException */
    public function load(string $aggregateClass, Uuid $aggregateUuid): EventSourcedAggregateRoot
    {
        /** @var EventEntity[] $aggregateEvents */
        $aggregateEvents = $this->repository->findBy(['aggregateId' => $aggregateUuid], ['occurredOn' => 'ASC']);

        $reflection = new ReflectionClass($aggregateClass);

        /** @var EventSourcedAggregateRoot $aggregate */
        $aggregate = $reflection->newInstanceWithoutConstructor();

        foreach ($aggregateEvents as $aggregateEvent) {
            $domainEventClassName = $aggregateEvent->getEventType();

            if (!method_exists($domainEventClassName, 'fromArray')) {
                throw new \RuntimeException('Cannot instantiate event, method fromArray not found');
            }

            $domainEvent = $domainEventClassName::fromArray($aggregateEvent->getPayload());
            $aggregate->apply($domainEvent);
        }

        return $aggregate;
    }

    public function store(EventSourcedAggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->getUncommittedEvents();
        $lastEventPlayhead = $this->repository->getLastEventPlayheadByAggregateId($aggregateRoot->getId());

        foreach ($events as $domainEvent) {
            ++$lastEventPlayhead;
            $id = Uuid::v4();
            $occurredOn = new DateTimeImmutable('now');
            $payload = $domainEvent->toArray();

            $event = new EventEntity($id, $domainEvent->getId(), $domainEvent::class, $payload, $lastEventPlayhead, $occurredOn);

            // store event in event storage
            $this->repository->save($event);

            // dispatch event through the system
            $this->dispatcher->dispatch($domainEvent, $domainEvent::class);
        }
    }
}
