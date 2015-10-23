<?php

  // Database file
  // Here we define functions to initialize database

  // Set site variable
  define('IN_PR', TRUE);
  //if (!defined(IN_PR)) exit;

  require_once("includes/config.php");
  require_once("includes/classes/DBM.php");

  $DBM = new DBM(DB_USER, DB_PASS, DB_HOST);

  // Not needed anymore unset for security
  unset($password);

  // Create database site
  $DBM->query("CREATE DATABASE IF NOT EXISTS `site`;");

  // Create database login
  $DBM->query("CREATE DATABASE IF NOT EXISTS `login`;");

  // Create table users
  $DBM->query("CREATE TABLE IF NOT EXISTS `login`.`users` (
               `user_id`                      int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
               `user_name`                    varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
               `user_password_hash`           varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
               `user_email`                   varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
               `user_active`                  tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s activation status',
               `user_activation_hash`         varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s email verification hash string',
               `user_password_reset_hash`     char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s password reset code',
               `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
               `user_rememberme_token`        varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user''s remember-me cookie token',
               `user_failed_logins`           tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user''s failed login attemps',
               `user_last_failed_login`       int(10) DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
               `user_registration_datetime`   datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
               `user_registration_ip`         varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0', PRIMARY KEY (`user_id`),
               UNIQUE KEY `user_name` (`user_name`),
               UNIQUE KEY `user_email` (`user_email`)
              ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';");
?>
