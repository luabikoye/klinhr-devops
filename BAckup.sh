#!/bin/bash

TIMESTAMP=$(date +"%Y-%m-%d_%H-%M-%S")
sudo mkdir -p $TIMESTAMP
cp -R /var/www/html/uploads $TIMESTAMP

mysqldump --no-tablespaces --single-transaction --skip-lock-tables -h localhost -u aledoypr_saverite -p'Aledoy1234$#@!' aledoypr_saverite > saverite_backup.sql

mv saverite_backup.sql $TIMESTAMP/saverite_backup.sql

sudo zip -r $TIMESTAMP.zip $TIMESTAMP

scp $TIMESTAMP.zip root@kennedijobs.com:/home/backups/

echo "Back up successful at $TIMESTAMP"

rm -rf $TIMESTAMP.zip $TIMESTAMP