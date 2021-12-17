<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\UserId;

final class UserWasCreated implements DomainEvent
{
    public readonly UserId $id;
    public readonly Credentials $credentials;

    public function __construct(UserId $id, Credentials $credentials)
    {
        $this->id = $id;
        $this->credentials = $credentials;
    }
}
