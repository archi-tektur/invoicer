<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Symfony\Response;

final class FormattedResponse
{
    public int $code;
    public string $message;
    public string|null $details;
    public array|null $data;
    public array $headers;
}
