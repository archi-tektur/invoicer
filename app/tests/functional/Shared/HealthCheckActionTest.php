<?php

declare(strict_types=1);

namespace App\FunctionalTests\Shared;

use Monolog\Test\TestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class HealthCheckActionTest extends TestCase
{
    /**
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function test_health_check_works_properly(): void
    {
        $client = HttpClient::create();

        $response = $client->request('GET', "http://app:8080/api/health_check");
        $payload = $response->toArray();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', array_shift($response->getHeaders()['content-type']));


        $this->assertEquals('OK', $payload['status']);
    }
}
