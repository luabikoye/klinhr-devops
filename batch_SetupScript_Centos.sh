#!/bin/bash

      sudo yum install -y httpd wget vim unzip
      sudo systemctl start httpd
      sudo systemctl enable httpd
      mkdir -p /tmp/klinhr
       cd /tmp/klinhr
       wget --header 'Authorization: token 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' https://github.com/aledoysolutions/klinhr/archive/refs/heads/main.zip
       unzip -o main.zip
       cp -r klinhr-main/* /var/www/html/

       wget https://files.phpmyadmin.net/phpMyAdmin/5.2.1/phpMyAdmin-5.2.1-all-languages.zip
       unzip phpMyAdmin-5.2.1-all-languages.zip
       mv phpMyAdmin-5.2.1-all-languages /var/www/html/phpMyAdmin


       systemctl restart httpd
       cd /tmp/
       rm -rf /tmp/klinhr
echo
echo "###########################"
echo "Server & Gets codes ready"
echo "###########################"


	yum install mariadb-server -y
        systemctl start mariadb
        systemctl enable mariadb.service

        mysql -u root -e 'CREATE DATABASE ecardnai_Klinhr;'
        mysql -u root -e 'GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER ON ecardnai_Klinhr. * TO ecardnai_Klinhr@localhost IDENTIFIED BY "Certification231!"'
        mysql -u root -e 'FLUSH PRIVILEGES;'



mysql -u ecardnai_Klinhr -pCertification231! ecardnai_Klinhr < /var/www/html/db/ecardnai_Klinhr.sql

echo
echo "###########################"
echo "Database installed successfully"
echo "###########################"

sudo yum -y install epel-release

# Install PHP from the Remi repository
sudo yum -y install https://rpms.remirepo.net/enterprise/remi-release-7.rpm
sudo yum -y install yum-utils
sudo yum-config-manager --disable 'remi-php*'
sudo yum-config-manager --enable remi-php80
sudo yum -y install php php-cli php-common php-fpm php-mysql php-json php-opcache php-mbstring php-xml php-gd php-curl php-pear


#add the following code to apache config file

# Define the code to add to httpd.conf
# code_to_add="<FilesMatch \\.php$>\n SetHandler application/x-httpd-php\n</FilesMatch>"

# # Check if the httpd.conf file exists
# if [ -f "/etc/httpd/conf/httpd.conf" ]; then
#     # Append the code to httpd.conf
#     echo -e "$code_to_add" | sudo tee -a /etc/httpd/conf/httpd.conf > /dev/null
#     echo "Code added to /etc/httpd/conf/httpd.conf"
# else
#     echo "httpd.conf file not found. Please check your Apache configuration."
# fi



# Check the installed PHP version
sudo php -v

echo
echo "###########################"
echo "PHP 8 installed successfully"
echo "###########################"




# Enable mod_rewrite and define the directory and configuration directive

sudo yum install mod_rewrite

sudo sed -i '/<Directory "\/var\/www\/html">/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/httpd/conf/httpd.conf


#rename htaccess file
mv /var/www/html/_htaccess /var/www/html/.htaccess

echo
echo "##############################################"
echo "Rename .htaccess file and set up mod_rewrite done"
echo "##############################################"




#restart apache
systemctl restart httpd

#remove batch script from uploaded file.
rm /var/www/html/*.sh -y


echo
echo "###########################"
echo "Website and Server is ready"
echo "###########################"
