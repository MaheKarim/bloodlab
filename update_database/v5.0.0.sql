ALTER TABLE `personal_access_tokens` ADD `expires_at` TIMESTAMP NULL DEFAULT NULL AFTER `last_used_at`;


ALTER TABLE `general_settings` ADD `socialite_credentials` TEXT AFTER `active_template`;

UPDATE `general_settings` SET `socialite_credentials` = '{\"google\":{\"client_id\":\"------------\",\"client_secret\":\"-------------\",\"status\":1},\"facebook\":{\"client_id\":\"------\",\"client_secret\":\"------\",\"status\":1},\"linkedin\":{\"client_id\":\"-----\",\"client_secret\":\"-----\",\"status\":1}}' WHERE `general_settings`.`id` = 1;

ALTER TABLE `general_settings` ADD `firebase_config` TEXT AFTER `sms_config`;

ALTER TABLE `general_settings` ADD `pn` TINYINT(1) NOT NULL DEFAULT '1' AFTER `sn`;

ALTER TABLE `general_settings` CHANGE `sms_body` `sms_template` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `general_settings` ADD `push_template` VARCHAR(255) NULL DEFAULT NULL AFTER `sms_from`;

ALTER TABLE `notification_templates` ADD `push_body` TEXT AFTER `sms_body`, ADD `push_status` TINYINT(1) NOT NULL DEFAULT '0' AFTER `push_body`;

ALTER TABLE `notification_templates` CHANGE `shortcodes` `shortcodes` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `push_body`, CHANGE `email_status` `email_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `shortcodes`, CHANGE `sms_status` `sms_status` TINYINT(1) NOT NULL DEFAULT '1' AFTER `email_status`;

CREATE TABLE `device_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `is_app` tinyint(1) NOT NULL DEFAULT 0,
  `token` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `device_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;


ALTER TABLE `notification_logs` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `notification_type`;

ALTER TABLE `frontends` ADD `slug` VARCHAR(255) NULL DEFAULT NULL AFTER `tempname`;
ALTER TABLE `frontends` ADD `seo_content` LONGTEXT AFTER `data_values`;


UPDATE `extensions` SET `script` = '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>' WHERE `extensions`.`act` = 'google-analytics';

UPDATE `extensions` SET `shortcode` = '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}' WHERE `extensions`.`act` = 'google-analytics';

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES (NULL, '0', '510', 'Binance', 'Binance', '1', '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', '1', '', NULL, NULL, '2023-02-14 11:08:04');


INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES (NULL, '0', '124', 'SslCommerz', 'SslCommerz', '1', '{\"store_id\": {\"title\": \"Store ID\",\"global\": true,\"value\": \"---------\"},\"store_password\": {\"title\": \"Store Password\",\"global\": true,\"value\": \"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', '0', NULL, NULL, NULL, '2023-05-06 13:43:01');

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES (NULL, '0', '125', 'Aamarpay', 'Aamarpay', '1', '{\"store_id\": {\"title\": \"Store ID\",\"global\": true,\"value\": \"---------\"},\"signature_key\": {\"title\": \"Signature Key\",\"global\": true,\"value\": \"----------\"}}', '{\"BDT\":\"BDT\"}', '0', NULL, NULL, NULL, '2023-05-06 13:43:01');


UPDATE `gateways` SET `extra` = '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}' WHERE `gateways`.`alias` = 'Binance';

ALTER TABLE `general_settings` ADD `paginate_number` INT NOT NULL DEFAULT '0' AFTER `system_customized`;

ALTER TABLE `cron_jobs` CHANGE `is_default` `is_default` TINYINT(1) NOT NULL DEFAULT '1';

ALTER TABLE `cron_job_logs` CHANGE `cron_job_id` `cron_job_id` INT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `languages` ADD `image` VARCHAR(40) NULL DEFAULT NULL AFTER `is_default`;

ALTER TABLE `users` ADD `provider` VARCHAR(255) NULL DEFAULT NULL AFTER `remember_token`;

ALTER TABLE `deposits` ADD `success_url` VARCHAR(255) NULL DEFAULT NULL AFTER `admin_feedback`, ADD `failed_url` VARCHAR(255) NULL DEFAULT NULL AFTER `success_url`;


UPDATE `notification_templates` SET `name` = 'KYC Rejected' WHERE `notification_templates`.`act` = 'KYC_REJECT';

ALTER TABLE `general_settings` ADD `currency_format` INT NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only' AFTER `paginate_number`;

ALTER TABLE `notification_templates` ADD `email_sent_from_name` VARCHAR(40) NULL DEFAULT NULL AFTER `email_status`, ADD `email_sent_from_address` VARCHAR(40) NULL DEFAULT NULL AFTER `email_sent_from_name`;

ALTER TABLE `notification_templates` ADD `sms_sent_from` VARCHAR(40) NULL DEFAULT NULL AFTER `sms_status`;

ALTER TABLE `support_attachments` CHANGE `support_message_id` `support_message_id` INT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `users` ADD `kyc_rejection_reason` VARCHAR(255) NULL DEFAULT NULL AFTER `kyc_data`;

UPDATE `notification_templates` SET `shortcodes` = '{\"reason\":\"Rejection Reason\"}' WHERE `notification_templates`.`act` = 'KYC_REJECT';

DELETE FROM `gateway_currencies` WHERE `gateway_currencies`.`method_code` = 108;
DELETE FROM `gateways` WHERE `gateways`.`code` = 108;

ALTER TABLE `gateways` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `alias`;

ALTER TABLE `withdraw_methods` ADD `image` VARCHAR(255) NULL DEFAULT NULL AFTER `name`;

ALTER TABLE `general_settings` ADD `in_app_payment` TINYINT(1) NOT NULL DEFAULT '1' AFTER `force_ssl`;

ALTER TABLE `gateway_currencies` DROP `image`;

ALTER TABLE `notification_templates` CHANGE `subj` `subject` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `notification_templates` ADD `push_title` VARCHAR(255) NULL DEFAULT NULL AFTER `subject`;

ALTER TABLE `general_settings` ADD `push_title` VARCHAR(255) NULL DEFAULT NULL AFTER `sms_from`;

ALTER TABLE `general_settings` ADD `email_from_name` VARCHAR(255) NULL DEFAULT NULL AFTER `email_from`;

ALTER TABLE `deposits` ADD `last_cron` INT NULL DEFAULT '0' AFTER `failed_url`;

DELETE FROM `gateway_currencies` WHERE `gateway_currencies`.`gateway_alias` = 'NowPaymentsCheckout';

UPDATE `gateways` SET `supported_currencies` = '{\"USD\":\"USD\",\"EUR\":\"EUR\"}' WHERE `gateways`.`alias` = 'NowPaymentsCheckout';


ALTER TABLE `general_settings` ADD `available_version` VARCHAR(40) NULL DEFAULT NULL AFTER `last_cron`;  --Don't forget to add the system version number here

ALTER TABLE `general_settings` DROP `system_info`;

ALTER TABLE `users` CHANGE `username` `username` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;

ALTER TABLE `pages` ADD `seo_content` TEXT NULL DEFAULT NULL AFTER `secs`;

ALTER TABLE `general_settings` CHANGE `currency_format` `currency_format` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only';

ALTER TABLE `general_settings` CHANGE `paginate_number` `paginate_number` INT(11) NOT NULL DEFAULT '0';



ALTER TABLE `users` ADD `country_name` VARCHAR(255) NULL DEFAULT NULL AFTER `password`, ADD `dial_code` INT NOT NULL DEFAULT '0' AFTER `country_name`, ADD `city` VARCHAR(255) NULL DEFAULT NULL AFTER `dial_code`, ADD `state` VARCHAR(255) NULL DEFAULT NULL AFTER `city`, ADD `zip` VARCHAR(255) NULL DEFAULT NULL AFTER `state`, ADD `address` TEXT NULL DEFAULT NULL AFTER `zip`;


ALTER TABLE `users` CHANGE `dial_code` `dial_code` VARCHAR(40) NOT NULL DEFAULT '0';
ALTER TABLE `users` CHANGE `dial_code` `dial_code` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;


ALTER TABLE `users` CHANGE `dial_code` `dial_code` VARCHAR(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL AFTER `email`;

UPDATE `gateways` SET `crypto` = '0' WHERE `gateways`.`alias` = 'TwoCheckout';


ALTER TABLE `users` DROP `addressss`;