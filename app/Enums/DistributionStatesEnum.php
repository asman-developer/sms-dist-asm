<?php

namespace App\Enums;

enum DistributionStatesEnum : int
{
    case PREPARING = 0;
    case PENDING = 1;
    case COMPLETED = 2;

    public static function fromKey(string $key): self
    {
        return match ($key) {
            'PREPARING' => self::PREPARING,
            'PENDING' => self::PENDING,
            'COMPLETED' => self::COMPLETED,
        };
    }

    public static function fromValue($key): string
    {
        return match ($key) {
            self::PREPARING->value => __('distribution_state_PREPARING'),
            self::PENDING->value => __('distribution_state_PENDING'),
            self::COMPLETED->value => __('distribution_state_COMPLETED'),
        };
    }

    public static function fromBadgeColor($key): string
    {
        return match ($key) {
            self::PREPARING->value => 'badge badge-soft-warning',
            self::PENDING->value => 'badge badge-soft-info',
            self::COMPLETED->value => 'badge badge-soft-success',
        };
    }
}
