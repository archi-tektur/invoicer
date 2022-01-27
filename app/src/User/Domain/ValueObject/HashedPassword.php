<?php

declare(strict_types=1);

namespace App\User\Domain\ValueObject;

use Assert\Assertion;
use Assert\AssertionFailedException;
use function is_bool;
use function password_hash;
use RuntimeException;

final class HashedPassword
{
    public const COST = 12;
    private string $hashedPassword;

    private function __construct(string $hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /** @throws AssertionFailedException */
    public static function encode(string $plainPassword): self
    {
        return new self(self::hash($plainPassword));
    }

    public static function fromHash(string $hashedPassword): self
    {
        return new self($hashedPassword);
    }

    public function match(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->hashedPassword);
    }

    public function toString(): string
    {
        return $this->hashedPassword;
    }

    /** @throws AssertionFailedException */
    private static function hash(string $plainPassword): string
    {
        Assertion::minLength($plainPassword, 6, 'Min 6 characters password');

        /** @var null|bool|string $hashedPassword */
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => self::COST]);

        if (is_bool($hashedPassword)) {
            throw new RuntimeException('Server error hashing password');
        }

        return (string) $hashedPassword;
    }
}
