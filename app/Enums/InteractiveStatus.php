<?php

namespace App\Enums;

enum InteractiveStatus: string
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
