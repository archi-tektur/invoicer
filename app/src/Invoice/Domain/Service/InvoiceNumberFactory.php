<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Service;

use App\Invoice\Domain\Repository\InvoiceRepository;
use App\Invoice\Domain\ValueObject\InvoiceNumber\InvoiceNumberInterface;
use App\Invoice\Domain\ValueObject\InvoiceNumber\OrderedYearSortedInvoiceNumber;
use App\Shared\Domain\Exception\AbstractDomainException;
use DateTimeImmutable;

final class InvoiceNumberFactory
{
    private InvoiceRepository $repository;

    public function __construct(InvoiceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function nextBasedOnPrevious(): InvoiceNumberInterface
    {
        $currentInvoice = $this->repository->getLastInvoiceNumber();

        if ($currentInvoice === null) {
            throw new AbstractDomainException('Cannot generate new number because user has no previous invoices.');
        }

        return $currentInvoice->next();
    }

    public function first(): InvoiceNumberInterface
    {
        $now = new DateTimeImmutable();
        $currentYear = (int)$now->format('Y');

        return new OrderedYearSortedInvoiceNumber(1, $currentYear);
    }
}
