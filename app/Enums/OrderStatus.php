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
}
