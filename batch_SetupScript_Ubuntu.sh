#!/bin/bash


#Update Server
sudo apt update

#install wget and zip
sudo apt install wget zip -y

#install apache2 and check firewall status
sudo apt install apache2 -y
sudo ufw app list


#restart Apache
sudo systemctl restart apache2

echo
echo "####################################"
echo "Apache Server installed successfully"
echo "####################################"



#Pull project from gits
sudo wget --header 'Authorization: token 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' https://github.com/luabikoye/klinhr-devops/archive/refs/heads/main.zip

sudo unzip main.zip

#remove default index.html in server directory
sudo rm -rf /var/www/html/index.html

#copy project to server directory
sudo cp -r klinhr-devops-main/* /var/www/html/

echo
echo "###############################################"
echo "Website files downloaded to server successfully"
echo "###############################################"


#install mysql
sudo apt install mysql-server -y

#create database
sudo mysql -u root -e 'CREATE DATABASE ecardnai_Klinhr;'

#create a user 
sudo mysql -u root -e 'CREATE USER "ecardnai_Klinhr"@"localhost" IDENTIFIED BY "Certification231!";'

#grant user all privileges to database
sudo mysql -u root -e "GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER ON ecardnai_Klinhr.* TO 'ecardnai_Klinhr'@'localhost';"
sudo mysql -u root -e 'FLUSH PRIVILEGES;'


#import database from project folder
sudo mysql -u root ecardnai_Klinhr < /var/www/html/db/ecardnai_Klinhr.sql


echo
echo "################################"
echo "MYSQL installed with DB imported"
echo "################################"


#install php
sudo apt install php libapache2-mod-php php-mysql -y
php -v

echo
echo "################################"
echo "PHP installed successfully"
echo "################################"

#mod rewrite for htaccess
sudo a2enmod rewrite
sudo sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
sudo mv /var/www/html/_htaccess /var/www/html/.htaccess


#restart Apache
sudo systemctl restart apache2
echo
echo "#########################################"
echo "Server Restarted and Everything Live!!!!!"
echo "#########################################"

sudo rm /var/www/html/*.sh