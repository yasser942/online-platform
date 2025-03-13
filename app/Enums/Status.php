<?php

namespace App\Enums;

enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getColor(): string
    {
    return match ($this) {
        self::ACTIVE => 'success',
        self::INACTIVE => 'danger',
    };
}
}