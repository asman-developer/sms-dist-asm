<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'ADMIN';
    case MANAGER = 'MANAGER';

    public static function asArray(): array
    {
        return array_map(static fn(self $role) => $role->name, self::cases());
    }
}
