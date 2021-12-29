<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEvent;

abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /** @var DomainEvent[] */
    private array $uncommittedEvents = [];
    private int $playhead = -1;

    public function apply(DomainEvent $event): void
    {
        $this->handle($event);

        ++$this->playhead;
        $this->uncommittedEvents[] = $event;
    }

    /** @return  DomainEvent[] */
    public function getUncommittedEvents(): array
    {
        return $this->uncommittedEvents;
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    protected function handle(DomainEvent $event): void
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->{$method}($event);
    }

    private function getApplyMethod(DomainEvent $event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply'.end($classParts);
    }
}
