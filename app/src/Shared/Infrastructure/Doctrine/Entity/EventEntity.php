<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Entity;

use App\Shared\Infrastructure\Doctrine\Repository\EventsRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
#[ORM\Table(name: 'events')]
class EventEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'uuid')]
    private Uuid $aggregateId;

    #[ORM\Column(type: 'string')]
    private string $eventType;

    #[ORM\Column(type: 'json')]
    private array $payload;

    #[ORM\Column(type: 'integer')]
    private int $playhead;

    #[ORM\Column(type: 'datetime_immutable')]
    private DateTimeImmutable $occurredOn;

    public function __construct(
        Uuid $id,
        Uuid $aggregateId,
        string $eventType,
        array $payload,
        int $playhead,
        DateTimeImmutable $occurredOn
    ) {
        $this->id = $id;
        $this->aggregateId = $aggregateId;
        $this->eventType = $eventType;
        $this->payload = $payload;
        $this->occurredOn = $occurredOn;
        $this->playhead = $playhead;
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

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}
