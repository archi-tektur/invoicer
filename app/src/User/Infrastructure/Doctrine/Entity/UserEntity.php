<?php

declare(strict_types=1);

namespace App\User\Infrastructure\Doctrine\Entity;

use App\User\Infrastructure\Doctrine\Repository\DoctrineUserRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: DoctrineUserRepository::class)]
final class UserEntity implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public readonly Uuid $id;

    #[ORM\Column(type: 'string')]
    public string $email;

    #[ORM\Column(type: 'string')]
    public string $hashedPassword;

    public function __construct(Uuid $id, string $email, string $hashedPassword)
    {
        $this->id = $id;
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /** @see UserInterface */
    public function getSalt(): ?string
    {
        return null;
    }

    /** @see UserInterface */
    public function eraseCredentials(): void
    {
    }

    /** @see UserInterface */
    public function getPassword(): ?string
    {
        return $this->hashedPassword;
    }

    /** @see UserInterface */
    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    #[Pure]
    /** @see UserInterface */
    public function getUserIdentifier(): string
    {
        return $this->id->toRfc4122();
    }
}
