#!/bin/bash
echo "Installing Bitrix..."
echo $DISTR_URL

wget $DISTR_URL -O /tmp/bitrix.tar.gz
mv /var/www/index.php /var/www/index.php.setup
mkdir /tmp/bitrix
tar xvf /tmp/bitrix.tar.gz -C /tmp/bitrix
cp -vnpr /tmp/bitrix/* /var/www
rm /tmp/bitrix.tar.gz
rm -R /tmp/bitrix
chmod -R a+rwX /var/www/

echo "Now visit http://localhost:${HTTP_PORT}/index.php"