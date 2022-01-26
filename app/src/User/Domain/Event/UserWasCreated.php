<?php

declare(strict_types=1);

namespace App\User\Domain\Event;

use App\Shared\Domain\Event\DomainEvent;
use App\User\Domain\User;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\UserId;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Uid\Uuid;

final class UserWasCreated implements DomainEvent
{
    public readonly UserId $id;
    public readonly Credentials $credentials;

    public function __construct(UserId $id, Credentials $credentials)
    {
        $this->id = $id;
        $this->credentials = $credentials;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->toRfc4122(),
            'credentials' => [
                'email' => $this->credentials->email->toString(),
                'password' => $this->credentials->hashedPassword->toString()
            ]
        ];
    }

    public static function fromArray(array $array): self
    {
        $id = UserId::fromString($array['id']);

        $email = Email::fromString($array['credentials']['email']);
        $hashedPassword = HashedPassword::fromHash($array['credentials']['password']);

        $credentials = new Credentials($email, $hashedPassword);

        return new self($id, $credentials);
    }
}
