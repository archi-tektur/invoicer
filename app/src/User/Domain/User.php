<?php

declare(strict_types=1);

namespace App\User\Domain;

use App\Shared\Domain\EventSourcedAggregateRoot;
use App\User\Domain\Event\UserSignedIn;
use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Exception\InvalidCredentialsException;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\UserId;
use Symfony\Component\Uid\Uuid;

final class User extends EventSourcedAggregateRoot
{
    private UserId $id;
    private Credentials $credentials;

    public function __construct(Uuid $id, Credentials $credentials)
    {
        $userId = UserId::fromString($id->toRfc4122());

        $event = new UserWasCreated($userId, $credentials);
        $this->apply($event);
    }

    public function signIn(Email $email, string $plainPassword): void
    {
        if (!$this->credentials->match($email, $plainPassword)) {
            throw new InvalidCredentialsException();
        }

        $event = new UserSignedIn($this->id);
        $this->apply($event);
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->id = $event->id;
        $this->credentials = $event->credentials;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
