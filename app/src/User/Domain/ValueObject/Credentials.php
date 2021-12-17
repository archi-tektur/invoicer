<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

final class Credentials
{
    public readonly Email $email;
    public readonly HashedPassword $hashedPassword;

    public function __construct(Email $email, HashedPassword $hashedPassword)
    {
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    public function match(Email $email, string $plainPassword): bool
    {
        $emailMatches = $this->email === $email;
        $passwordMatches = $this->hashedPassword->match($plainPassword);

        return $emailMatches && $passwordMatches;
    }
}
