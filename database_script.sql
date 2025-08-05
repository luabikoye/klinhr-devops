CREATE TABLE `ecardnai_Klinhr`.`clockin` (`id` INT NOT NULL AUTO_INCREMENT , `token` TEXT NOT NULL , `clockin` DATETIME NOT NULL , `clockout` DATETIME NOT NULL , `staff_id` VARCHAR(100) NOT NULL , `client_id` VARCHAR(100) NOT NULL , `ipaddress` VARCHAR(100) NOT NULL , `macaddress` VARCHAR(100) NOT NULL , `long` VARCHAR(100) NOT NULL , `latitude` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `clients` ADD `online_gua` ENUM('yes','no') NULL DEFAULT 'no' AFTER `logo`, ADD `clockin` ENUM('enabled','disabled') NULL DEFAULT 'disabled' AFTER `online_gua`;

CREATE TABLE `ecardnai_Klinhr`.`clockin_setting` (`id` INT NOT NULL , `token` TEXT NOT NULL , `setting` ENUM('enable','disabled') NOT NULL DEFAULT 'disabled' , `geofence` VARCHAR(100) NOT NULL , `client_id` VARCHAR(100) NOT NULL , `clockin` VARCHAR(100) NOT NULL , `geolocation` VARCHAR(100) NOT NULL ) ENGINE = InnoDB;

ALTER TABLE `clockin_setting` CHANGE `id` `id` INT NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);

CREATE TABLE `ecardnai_Klinhr`.`break` (`id` INT NOT NULL AUTO_INCREMENT , `token` TEXT NOT NULL , `clockin_token` TEXT NOT NULL , `break_start` DATETIME NOT NULL , `break_end` DATETIME NOT NULL , `staff_id` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `clockin_setting` CHANGE `geofence` `geofence` ENUM('onsite','flexible','both') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;

ALTER TABLE `clockin_setting` CHANGE `geolocation` `geolocation` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;

ALTER TABLE `clockin` CHANGE `clockout` `clockout` DATETIME NULL;

ALTER TABLE `clients` ADD `ip_address` VARCHAR(100) NULL AFTER `clockin`;

ALTER TABLE `clockin` ADD `note` TEXT NULL AFTER `latitude`;

ALTER TABLE `break` CHANGE `break_end` `break_end` DATETIME NULL;
