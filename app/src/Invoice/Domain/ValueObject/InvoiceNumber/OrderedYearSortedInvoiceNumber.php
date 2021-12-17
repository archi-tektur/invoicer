<?php

declare(strict_types=1);

namespace App\Invoice\Domain\ValueObject\InvoiceNumber;

use InvalidArgumentException;

final class OrderedYearSortedInvoiceNumber implements InvoiceNumberInterface
{
    private readonly int $order;
    private readonly int $year;

    public function __construct(int $order, int $year)
    {
        if ($order < 0) {
            throw new InvalidArgumentException('Invoice number cannot be below 1.');
        }

        $this->order = $order;
        $this->year = $year;
    }

    public static function fromString(string $number): self
    {
    }

    public function toString(): string
    {
        return "{$this->order}/{$this->year}";
    }

    public function next(): self
    {
        $nextOrder = $this->order + 1;

        return new self($nextOrder, $this->year);
    }
}
