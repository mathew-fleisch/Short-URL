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

# Setup PhishTank service
# echo $(crontab -l ; echo '* * * * * echo "Blah" > /home/vagrant/blah.txt') | crontab -