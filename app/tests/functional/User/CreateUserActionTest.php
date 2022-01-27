<?php

declare(strict_types=1);

namespace App\FunctionalTests\User;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
class CreateUserActionTest extends TestCase
{
    public function testCreateUser(): void
    {
        $client = HttpClient::create();

        $data = ['email' => 'test@example.com', 'password' => 'raw_password'];

        $response = $client->request('POST', 'http://app:8080/api/user', ['json' => $data]);
        $payload = $response->toArray();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals('application/json', array_shift($response->getHeaders()['content-type']));

        $this->assertEquals('Created', $payload['message']);
        $this->assertEquals('User created successfully.', $payload['details']);

        self::assertTrue(Uuid::isValid($payload['data']['id']));
    }
}
