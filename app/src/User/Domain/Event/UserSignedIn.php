<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\User\Domain\ValueObject\UserId;

final class UserSignedIn implements DomainEvent
{
    public readonly UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }
}
