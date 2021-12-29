<?php

declare(strict_types=1);

namespace App\FunctionalTests\User;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CreateUserActionTest extends TestCase
{
    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function test_create_user(): void
    {
        $client = HttpClient::create();

        $response = $client->request('POST', 'http://app:8080/api/user');
        $payload = $response->toArray();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', array_shift($response->getHeaders()['content-type']));
        $this->assertEquals('Hello, world!', $payload['message']);
    }
}
