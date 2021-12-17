<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Repository;

use App\Invoice\Domain\ValueObject\InvoiceNumber\InvoiceNumberInterface;

interface InvoiceRepository
{
    public function getLastInvoiceNumber(): InvoiceNumberInterface;
}
