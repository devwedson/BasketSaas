<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Aguardando pagamento',
            self::Approved => 'Pago',
            self::Rejected => 'Recusado',
            self::Cancelled => 'Cancelado',
            self::Expired => 'Expirado',
        };
    }

    public function isPaid(): bool
    {
        return $this === self::Approved;
    }
}