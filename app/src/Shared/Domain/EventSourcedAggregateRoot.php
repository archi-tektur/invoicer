<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Event\DomainEventInterface;

abstract class EventSourcedAggregateRoot implements AggregateRoot
{
    /** @var DomainEventInterface[] */
    private array $uncommittedEvents = [];
    private int $playhead = -1;

    public function apply(DomainEventInterface $event): void
    {
        $this->handle($event);

        ++$this->playhead;
        $this->uncommittedEvents[] = $event;
    }

    /** @return  DomainEventInterface[] */
    public function getUncommittedEvents(): array
    {
        return $this->uncommittedEvents;
    }

    public function getPlayhead(): int
    {
        return $this->playhead;
    }

    protected function handle(DomainEventInterface $event): void
    {
        $method = $this->getApplyMethod($event);

        if (!method_exists($this, $method)) {
            return;
        }

        $this->{$method}($event);
    }

    private function getApplyMethod(DomainEventInterface $event): string
    {
        $classParts = explode('\\', get_class($event));

        return 'apply'.end($classParts);
    }
}
