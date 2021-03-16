#!/bin/sh
envsubst < /etc/msmtprc.template > /etc/msmtprc
[ ! -d "/var/www/bitrix/components" ] && /usr/local/sbin/install_bitrix.sh
[ -f "/var/www/index.php.setup" ] && mv -f /var/www/index.php.setup /var/www/index.php.setup

screen -d -m /usr/local/sbin/cron_events.sh $CRON_INTERVAL_SEC
php-fpm