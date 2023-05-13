<?php

namespace App\Enums;

enum SmsTypeEnum : int
{
    case OUTBOX = 0;
    case INBOX = 1;

    public static function fromKey(string $key) : self
    {
        return match($key)
        {
            'OUTBOX'   => self::OUTBOX,
            'INBOX'     => self::INBOX,
        };
    }
}
