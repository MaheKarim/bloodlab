UPDATE `extensions` SET `support` = 'fb_com.png' WHERE `extensions`.`act` = 'fb-comment';
ALTER TABLE `users` ADD `provider_id` VARCHAR(255) NULL DEFAULT NULL AFTER `provider`;
DROP TABLE `cache`, `cache_locks`, `sessions`;
ALTER TABLE `notification_logs` ADD `user_read` TINYINT NOT NULL DEFAULT '0' AFTER `image`;