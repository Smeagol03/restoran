<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Preparing = 'preparing';
    case Ready = 'ready';
    case Delivered = 'delivered';
    case Done = 'done';
    case Cancelled = 'cancelled';
    case Failed = 'failed';

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'yellow',
            self::Confirmed => 'blue',
            self::Preparing => 'indigo',
            self::Ready => 'purple',
            self::Delivered => 'green',
            self::Done => 'emerald',
            self::Cancelled => 'red',
            self::Failed => 'rose',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Confirmed => 'Dikonfirmasi',
            self::Preparing => 'Sedang Dimasak',
            self::Ready => 'Siap Disajikan',
            self::Delivered => 'Sedang Diantar',
            self::Done => 'Selesai',
            self::Cancelled => 'Dibatalkan',
            self::Failed => 'Gagal',
        };
    }

    /**
     * Get a customer-facing description of the status.
     */
    public function description(): string
    {
        return match ($this) {
            self::Pending => 'Pesanan Anda sedang menunggu konfirmasi dari restoran.',
            self::Confirmed => 'Restoran telah menerima pesanan Anda.',
            self::Preparing => 'Koki sedang menyiapkan pesanan Anda.',
            self::Ready => 'Pesanan Anda sudah siap!',
            self::Delivered => 'Pesanan Anda sedang dalam perjalanan.',
            self::Done => 'Pesanan telah selesai. Terima kasih!',
            self::Cancelled => 'Pesanan ini telah dibatalkan.',
            self::Failed => 'Pesanan gagal diproses.',
        };
    }

    /**
     * Get the progress percentage for the status timeline.
     */
    public function progressPercentage(): int
    {
        return match ($this) {
            self::Pending => 0,
            self::Confirmed => 20,
            self::Preparing => 40,
            self::Ready => 60,
            self::Delivered => 80,
            self::Done => 100,
            self::Cancelled => 0,
            self::Failed => 0,
        };
    }

    /**
     * Determine if this is a terminal (final) status.
     */
    public function isTerminal(): bool
    {
        return in_array($this, [self::Done, self::Cancelled, self::Failed]);
    }

    /**
     * Determine if this is an active (in-progress) status.
     */
    public function isActive(): bool
    {
        return ! $this->isTerminal();
    }

    /**
     * Get the ordered steps for the normal flow timeline.
     *
     * @return list<self>
     */
    public static function timelineSteps(): array
    {
        return [
            self::Pending,
            self::Confirmed,
            self::Preparing,
            self::Ready,
            self::Delivered,
            self::Done,
        ];
    }
}
