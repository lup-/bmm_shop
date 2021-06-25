#!/bin/sh
envsubst < /etc/msmtprc.template > /etc/msmtprc
chown www-data:www-data /etc/msmtprc
chmod 600 /etc/msmtprc

touch /var/log/msmtp.log
chown www-data:www-data /var/log/msmtp.log

[ ! -d "/var/www/bitrix/components" ] && /usr/local/sbin/install_bitrix.sh
[ -f "/var/www/index.php.setup" ] && mv -f /var/www/index.php.setup /var/www/index.php.setup

screen -d -m /usr/local/sbin/cron_events.sh $CRON_INTERVAL_SEC
php-fpm