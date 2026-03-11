<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case Kasir = 'kasir';
    case Customer = 'customer';

    /**
     * Get a human-readable label for the role.
     */
    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Kasir => 'Kasir',
            self::Customer => 'Customer',
        };
    }
}
