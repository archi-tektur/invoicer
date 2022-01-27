<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Request\Exception;

use RuntimeException;

final class MissingRequestParameterException extends RuntimeException
{
}
