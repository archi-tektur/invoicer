<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Symfony\Component\Uid\Uuid;

interface DomainEventInterface
{
    public function getId(): Uuid;

    public function toArray(): array;

    public static function fromArray(array $array): self;
}
