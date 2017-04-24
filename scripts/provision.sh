#!/bin/bash
#
# This script is executed upon the first `vagrant up` or when running
# `vagrant up --provision`. You may use it to install any additional software
# that you require for your submission.
#
#
set -e


# Workaround to enable htaccess file 
sed -i '164,168s/AllowOverride\ None/AllowOverride All/g' /etc/apache2/apache2.conf
service apache2 restart

# Initialize Database
mysql -uroot < /var/www/application/config/init.sql


# Setup PhishTank service
mkdir -p /var/www/data
cd /var/www/data
rm -rf online-valid.json.bz2;
rm -rf online-valid.json;
wget http://data.phishtank.com/data/online-valid.json.bz2
bzip2 -d online-valid.json.bz2
/usr/bin/php /var/www/data/phishy.php