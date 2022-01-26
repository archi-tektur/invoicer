<?php

declare(strict_types=1);

namespace App\Invoice\Domain\Event;

use App\Invoice\Domain\ValueObject\InvoiceNumber\InvoiceNumberInterface;
use App\Invoice\Domain\ValueObject\InvoiceStatus;
use App\Shared\Domain\Event\DomainEvent;
use App\User\Domain\ValueObject\UserId;
use Symfony\Component\Uid\Uuid;

final class InvoiceWasCreated
{
    public readonly Uuid $id;
    public readonly InvoiceNumberInterface $number;
    public readonly InvoiceStatus $status;
    public readonly UserId $user;

    public function __construct(Uuid $id, InvoiceNumberInterface $number, InvoiceStatus $status, UserId $user)
    {
        $this->id = $id;
        $this->number = $number;
        $this->status = $status;
        $this->user = $user;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }
}
