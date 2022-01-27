<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Request;

use ArchiTools\Request\AbstractRequestCommandResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class RequestObjectResolver extends AbstractRequestCommandResolver
{
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $interfaces = class_implements($argument->getType());
        $interfaceFound = in_array(Autoresolvable::class, $interfaces);

        if ($interfaceFound) {
            $this->logger->info('Request: using automatic object resolver.');
        }

        return $interfaceFound;
    }
}
