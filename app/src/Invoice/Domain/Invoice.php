<?php

declare(strict_types=1);

namespace App\Invoice\Domain;

use App\Invoice\Domain\Event\InvoiceWasCreated;
use App\Invoice\Domain\ValueObject\InvoiceNumber\InvoiceNumberInterface;
use App\Invoice\Domain\ValueObject\InvoiceStatus;
use App\Shared\Domain\EventSourcedAggregateRoot;
use App\User\Domain\User;
use Symfony\Component\Uid\Uuid;

final class Invoice extends EventSourcedAggregateRoot
{
    private readonly Uuid $id;
    private InvoiceNumberInterface $invoiceNumber;
    private InvoiceStatus $status;

    public function __construct(Uuid $id, InvoiceNumberInterface $number, InvoiceStatus $status, User $user)
    {
        $event = new InvoiceWasCreated($id, $number, $status, $user);
        $this->apply($event);
    }

    protected function applyInvoiceWasCreated(InvoiceWasCreated $event): void
    {
        $this->id = $event->id;
        $this->number = $event->number;
        $this->status = $event->status;
    }
}
