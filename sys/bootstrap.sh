#!/usr/bin/env bash

# Use single quotes instead of double quotes to make it work with special-character passwords
PASSWORD='123'
PROVISIONED=0
PROVISIONED_FILE='/home/vagrant/.provisioned'

if [ -e $PROVISIONED_FILE ]; then
    PROVISIONED=1
fi


if [ $PROVISIONED -eq 0 ]; then
    # update / upgrade
    sudo yum update
    sudo yum install -y epel-release

    # Install apache and other packages.
    sudo mkdir -p /var/www/logs
    sudo yum install -y httpd
    sudo yum install -y gdl
    sudo yum install -y gd
    sudo yum install -y ImageMagick
    sudo yum install -y php php-pear php-gd


    # install mysql and give password to installer
    sudo yum install -y mariadb-server mariadb
    sudo systemctl start mariadb.service
    mysqladmin -u root password "$PASSWORD"
    mysql -u root -p"$PASSWORD" -e "UPDATE mysql.user SET Password=PASSWORD('$PASSWORD') WHERE User='root'"
    mysql -u root -p"$PASSWORD" -e "DELETE FROM mysql.user WHERE User='root' AND Host NOT IN ('localhost', '127.0.0.1', '::1')"
    mysql -u root -p"$PASSWORD" -e "DELETE FROM mysql.user WHERE User=''"
    mysql -u root -p"$PASSWORD" -e "DELETE FROM mysql.db WHERE Db='test' OR Db='test\_%'"
    mysql -u root -p"$PASSWORD" -e "FLUSH PRIVILEGES"
    mysql -u root -p"$PASSWORD" -e "CREATE DATABASE xc5"
    zcat /var/www/sys/files/base.sql.gz | mysql -u root -p"$PASSWORD" xc5
    sudo yum install -y php-mysql

    # copy files in
    sudo cp /var/www/sys/files/etc/httpd/conf/httpd.conf /etc/httpd/conf/httpd.conf
    sudo cp /var/www/sys/files/etc/httpd/conf.d/vhost.conf /etc/httpd/conf.d/vhost.conf

    # restart apache
    sudo systemctl enable httpd.service

    touch "${PROVISIONED_FILE}"
fi

sudo systemctl restart httpd.service
sudo systemctl restart mariadb.service