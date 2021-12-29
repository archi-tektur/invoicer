<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Entity;

use DateTime;
use Symfony\Component\Uid\Uuid;

class Event
{
    private Uuid $id;
    private Uuid $aggregateId;
    private string $eventType;
    private array $payload;
    private DateTime $occurredOn;

    public function __construct(Uuid $id, Uuid $aggregateId, string $eventType, array $payload, DateTime $occurredOn)
    {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->occurredOn = $occurredOn;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getAggregateId(): Uuid
    {
        return $this->aggregateId;
    }

    public function getEventType(): string
    {
        return $this->eventType;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getOccurredOn(): DateTime
    {
        return $this->occurredOn;
    }
}
