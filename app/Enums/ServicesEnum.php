<?php

namespace App\Enums;

enum ServicesEnum : int
{
    case SHOP = 0;
    case ASMAN_MARKET = 1;
    case DISTRIBUTION = 2;

    public static function fromKey(string $key): self
    {
        return match ($key) {
            'SHOP' => self::SHOP,
            'ASMAN_MARKET' => self::ASMAN_MARKET,
            'DISTRIBUTION' => self::DISTRIBUTION,
        };
    }

    public static function fromValue($key): string
    {
        return match ($key) {
            self::SHOP->value => __('service_SHOP'),
            self::ASMAN_MARKET->value => __('service_ASMAN_MARKET'),
            self::DISTRIBUTION->value => __('service_DISTRIBUTION'),
        };
    }

    public static function fromBadgeColor($key): string
    {
        return match ($key) {
            self::SHOP->value => 'badge badge-soft-dark badge-border',
            self::ASMAN_MARKET->value => 'badge badge-soft-dark badge-border',
            self::DISTRIBUTION->value => 'badge badge-soft-dark badge-border',
            //self::OTHER->value => 'badge badge-soft-dark'
        };
    }
}
