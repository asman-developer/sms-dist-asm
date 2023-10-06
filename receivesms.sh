#!/bin/sh
from=$SMS_1_NUMBER
message=$SMS_1_TEXT

php /var/www/tp-sms-api/artisan app:sms:income "$from" "$message"