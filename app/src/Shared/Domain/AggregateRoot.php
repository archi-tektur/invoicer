<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use Symfony\Component\Uid\Uuid;

interface AggregateRoot
{
    public function getId(): Uuid;
}
