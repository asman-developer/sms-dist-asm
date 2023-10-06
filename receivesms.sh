#!/bin/sh
from=$SMS_1_NUMBER
message=$SMS_1_TEXT

php artisan app:sms:income "$from" "$message"