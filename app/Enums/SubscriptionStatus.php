<?php

namespace App\Enums;

enum SubscriptionStatus: string 
{
    case ACTIVE = 'active';
    case CANCELED = 'canceled';
    case EXPIRED = 'expired';

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::CANCELED => 'danger',
            self::EXPIRED => 'warning',
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::CANCELED => 'Canceled',
        };
    }
    // Return only ACTIVE and CANCELED cases
    public static function filteredCases(): array
    {
        return [
            self::ACTIVE,
            self::CANCELED,
        ];
    }
}
