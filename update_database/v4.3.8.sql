ALTER TABLE `admin_password_resets` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '1';
ALTER TABLE `deposits` CHANGE `try` `payment_try` INT(10) NOT NULL DEFAULT '0';
ALTER TABLE `general_settings` ADD `multi_language` TINYINT(1) NOT NULL DEFAULT '1' AFTER `agree`;