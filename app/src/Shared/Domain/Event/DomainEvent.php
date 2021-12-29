<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Symfony\Component\Uid\Uuid;

interface DomainEvent
{
    public function getId(): Uuid;
}
