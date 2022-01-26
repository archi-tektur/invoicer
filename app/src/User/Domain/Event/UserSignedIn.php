<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\User\Domain\ValueObject\UserId;
use Symfony\Component\Uid\Uuid;

final class UserSignedIn implements DomainEvent
{
    public readonly UserId $id;

    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return ['id'=> $this->id->toRfc4122()];
    }

    public static function fromArray(array $array): DomainEvent
    {
        return new self(UserId::fromString($array['id']));
    }
}
