ALTER TABLE `extensions` DROP `deleted_at`;
ALTER TABLE `languages` DROP `text_align`;
ALTER TABLE `languages` DROP `icon`;

ALTER TABLE `users` CHANGE `reg_step` `profile_complete` TINYINT(1) NOT NULL DEFAULT '0';

ALTER TABLE `admin_notifications` CHANGE `read_status` `is_read` TINYINT(1) NOT NULL DEFAULT '0';
ALTER TABLE `admin_password_resets` CHANGE `status` `status` TINYINT(0) NOT NULL DEFAULT '1';