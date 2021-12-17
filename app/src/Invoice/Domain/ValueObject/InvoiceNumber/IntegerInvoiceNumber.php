<?php

declare(strict_types=1);

namespace App\Invoice\Domain\ValueObject\InvoiceNumber;

use InvalidArgumentException;

final class IntegerInvoiceNumber implements InvoiceNumberInterface
{
    private readonly int $number;

    public function __construct(int $number)
    {
        if ($number < 1) {
            throw new InvalidArgumentException('Invoice number cannot be below 1.');
        }

        $this->number = $number;
    }

    public static function fromString(string $number): InvoiceNumberInterface
    {
        return new self((int)$number);
    }

    public function toString(): string
    {
        return (string)$this->number;
    }

    public function next(): IntegerInvoiceNumber
    {
        return new self($this->number + 1);
    }
}
