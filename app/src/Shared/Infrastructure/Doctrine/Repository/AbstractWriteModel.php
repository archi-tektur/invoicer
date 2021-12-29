<?php

namespace App\Shared\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\Shared\Infrastructure\Doctrine\Entity\Event;
use DateTime;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Uuid;

class AbstractWriteModel
{
    private EventsRepository $repository;
    private NormalizerInterface $normalizer;

    public function __construct(EventsRepository $repository, NormalizerInterface $normalizer)
    {
        $this->repository = $repository;
        $this->normalizer = $normalizer;
    }

    public function store(EventSourcedAggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->getUncommittedEvents();

        foreach ($events as $domainEvent){
            $id = Uuid::v4();
            $occurredOn = new DateTime('now');
            $payload = $this->normalizer->normalize($domainEvent);

            $event = new Event($id, $domainEvent->getId(), $domainEvent::class, $payload, $occurredOn);
            $this->repository->save($event);
        }
    }
}
