<?php

declare(strict_types=1);

namespace App\UnitTests\User\Domain;

use App\User\Domain\Event\UserSignedIn;
use App\User\Domain\Event\UserWasCreated;
use App\User\Domain\Exception\InvalidCredentialsException;
use App\User\Domain\User;
use App\User\Domain\ValueObject\Credentials;
use App\User\Domain\ValueObject\Email;
use App\User\Domain\ValueObject\HashedPassword;
use App\User\Domain\ValueObject\UserId;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
final class UserTest extends TestCase
{
    public function testBaseUserCreation(): void
    {
        $email = Email::fromString('test@example.com');
        $hashedPassword = HashedPassword::encode('test_password');

        $id = UserId::fromString('ffffffff-0001-ffff-ffff-ffffffffffff');
        $credentials = new Credentials($email, $hashedPassword);

        $user = new User($id, $credentials);

        $events = $user->getUncommittedEvents();

        self::assertCount(1, $events);
        self::assertInstanceOf(UserWasCreated::class, $events[0]);

        /** @var UserWasCreated $event */
        $event = $events[0];

        self::assertEquals('ffffffff-0001-ffff-ffff-ffffffffffff', $event->id->toRfc4122());
        self::assertEquals('test@example.com', $event->credentials->email->toString());
        self::assertEquals($hashedPassword, $event->credentials->hashedPassword);
    }

    public function testUserCanSignInWithCorrectData(): void
    {
        $email = Email::fromString('test@example.com');
        $hashedPassword = HashedPassword::encode('test_password');
        $id = UserId::fromString('ffffffff-0001-ffff-ffff-ffffffffffff');
        $credentials = new Credentials($email, $hashedPassword);
        $user = new User($id, $credentials);

        $user->signIn($email, 'test_password');

        $events = $user->getUncommittedEvents();

        self::assertCount(2, $events);
        self::assertInstanceOf(UserSignedIn::class, $events[1]);

        /** @var UserSignedIn $event */
        $event = $events[1];

        self::assertEquals('ffffffff-0001-ffff-ffff-ffffffffffff', $event->id->toRfc4122());
    }

    public function userCannotLogWithIncorrectEmail(): void
    {
        $email = Email::fromString('test@example.com');
        $hashedPassword = HashedPassword::encode('test_password');
        $id = UserId::fromString('ffffffff-0001-ffff-ffff-ffffffffffff');
        $credentials = new Credentials($email, $hashedPassword);
        $user = new User($id, $credentials);

        $this->expectException(InvalidCredentialsException::class);
        $user->signIn($email, 'specially_wrong_password');
    }

    public function userCannotLogWithIncorrectPassword(): void
    {
        $email = Email::fromString('test@example.com');
        $hashedPassword = HashedPassword::encode('test_password');
        $id = UserId::fromString('ffffffff-0001-ffff-ffff-ffffffffffff');
        $credentials = new Credentials($email, $hashedPassword);
        $user = new User($id, $credentials);

        $this->expectException(InvalidCredentialsException::class);
        $user->signIn(Email::fromString('speciallywrong_email@example.com'), 'test_password');
    }
}
