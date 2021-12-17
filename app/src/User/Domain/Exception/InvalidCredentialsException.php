<?php

declare(strict_types=1);

namespace App\User\Domain\Exception;

use App\Shared\Domain\Exception\AbstractDomainException;

final class InvalidCredentialsException extends AbstractDomainException
{
}
