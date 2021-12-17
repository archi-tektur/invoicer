<?php

declare(strict_types=1);

namespace App\Invoice\Domain\ValueObject\InvoiceNumber;

interface InvoiceNumberInterface
{
    public static function fromString(string $number): self;

    public function toString(): string;

    public function next(): self;
}
