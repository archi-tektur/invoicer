<?php

declare(strict_types=1);

namespace App\Invoice\Domain\ValueObject;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';

    case PUBLISHED = 'published';
}
