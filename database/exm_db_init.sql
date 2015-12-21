CREATE DATABASE IF NOT EXISTS `site`;

CREATE TABLE IF NOT EXISTS `site`.`users` (
    `user_id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',
    `user_real_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user\'s real name',
    `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user\'s name, unique',
    `user_courses` VARCHAR(128) DEFAULT 'a:0:{}' COMMENT 'serialized array with user\'s enlisted courses',
    `user_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user\'s password in salted and hashed format',
    `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user\'s email, unique',
    `user_active` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user\'s activation status',
    `user_activation_hash` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user\'s email verification hash string',
    `user_password_reset_hash` char(40) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user\'s password reset code',
    `user_password_reset_timestamp` bigint(20) DEFAULT NULL COMMENT 'timestamp of the password reset request',
    `user_rememberme_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'user\'s remember-me cookie token',
    `user_failed_logins` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'user\'s failed login attemps',
    `user_last_failed_login` INT UNSIGNED DEFAULT NULL COMMENT 'unix timestamp of last failed login attempt',
    `user_registration_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
    `user_registration_ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0.0.0.0',
    PRIMARY KEY (`user_id`),
    UNIQUE KEY `user_name` (`user_name`),
    UNIQUE KEY `user_email` (`user_email`)
) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

CREATE TABLE IF NOT EXISTS `site`.`courses` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `name` VARCHAR(64) NOT NULL COMMENT 'name of the course',
    `deadlines` VARCHAR(64) DEFAULT 'a:0:{}' COMMENT 'array with the course\'s dates for dealines',
    `projects` VARCHAR(128) DEFAULT 'a:0:{}' COMMENT 'projects assosiated with the course',
    `admins` VARCHAR(128) DEFAULT 'a:0:{}' COMMENT 'admin users for this course',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='course projects and other data related to each course';

CREATE TABLE IF NOT EXISTS `site`.`projects` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `subject` VARCHAR(64) NOT NULL COMMENT 'subject of the project',
    `stage` INT UNSIGNED DEFAULT '0' COMMENT 'stage of project ex start and finished',
    `grade` INT UNSIGNED DEFAULT '0' COMMENT 'grade of the project',
    `submissions` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'submissions linked to the project',
    `comments` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'array with id\'s of comments',
    `deadline` DATETIME NOT NULL COMMENT 'next deadline for the project',
    `students` VARCHAR(64) DEFAULT 'a:0:{}' COMMENT 'students linked to the project',
    `managers` VARCHAR(64) DEFAULT 'a:0:{}' COMMENT 'managers linked to the project',
    `examinators` VARCHAR(64) NOT NULL COMMENT 'examinators linked to the project',
    `reviewers` VARCHAR(512) DEFAULT 'a:0:{}' COMMENT 'reviewers linked to the project',
    `feasible_reviewers` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'feasible reviewers who can be linked to the project',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='data about all uploaded files';

CREATE TABLE IF NOT EXISTS `site`.`submissions` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `user` INT UNSIGNED NOT NULL COMMENT 'user id of the uploader',
    `date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time of the upload',
    `files` VARCHAR(64) DEFAULT 'a:0:{}' COMMENT 'array with files associated with the submission',
    `reviews` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'array with written reviews for the file',
    `comments` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'array with id\'s of comments',
    `grade` INT UNSIGNED DEFAULT '0' COMMENT 'grade of the submission',
    `stage` INT UNSIGNED DEFAULT '0' COMMENT 'stage of the project when the submission was filed',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='data about each submission and it\'s files';

CREATE TABLE IF NOT EXISTS `site`.`files` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `name` VARCHAR(64) NOT NULL COMMENT 'name of the file',
    `user` INT UNSIGNED NOT NULL COMMENT 'user id of the uploader',
    `date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time of the upload',
    `path` VARCHAR(64) NOT NULL COMMENT 'relative path to the file',
    `can_read` VARCHAR(64) DEFAULT 'a:0:{}' COMMENT 'array with users that have read permission',
    `virus_searched` TINYINT DEFAULT '0' COMMENT 'has the file been virus searched?',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='data about all uploaded files';

CREATE TABLE IF NOT EXISTS `site`.`comments` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `user` INT UNSIGNED NOT NULL COMMENT 'id of user submitting the comment',
    `date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time of submission',
    `data` VARCHAR(256) NOT NULL COMMENT 'content of comment',
    `subcomments` VARCHAR(64) NOT NULL DEFAULT 'a:0:{}' COMMENT 'array with id\'s of subcomments',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='data about comments';

CREATE TABLE IF NOT EXISTS `site`.`reviews` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
    `user` INT UNSIGNED NOT NULL COMMENT 'id of user submitting the review',
    `date` DATETIME DEFAULT '0000-00-00 00:00:00' COMMENT 'date and time of submission',
    `comments` VARCHAR(1024) DEFAULT 'a:0:{}' COMMENT 'array with id\'s of comments',
    `data` VARCHAR(8192) NOT NULL COMMENT 'content of review',
    PRIMARY KEY (`id`)
)  AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE = utf8_unicode_ci COMMENT='data from and about forms submitted by reviewers';

CREATE TABLE IF NOT EXISTS `site`.`roles` (
  `role_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(50) NOT NULL,

  PRIMARY KEY (`role_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `site`.`permissions` (
  `perm_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `perm_name` VARCHAR(50) NOT NULL,
  `perm_desc` VARCHAR(100) NOT NULL,

  PRIMARY KEY (`perm_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `site`.`role_perm` (
  `role_id` INT UNSIGNED NOT NULL,
  `perm_id` INT UNSIGNED NOT NULL,

  FOREIGN KEY (`role_id`) REFERENCES `site`.`roles`(`role_id`),
  FOREIGN KEY (`perm_id`) REFERENCES `site`.`permissions`(`perm_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `site`.`user_role` (
  `user_id` INT UNSIGNED NOT NULL,
  `role_id` INT UNSIGNED NOT NULL,

  FOREIGN KEY (`user_id`) REFERENCES `site`.`users`(`user_id`),
  FOREIGN KEY (`role_id`) REFERENCES `site`.`roles`(`role_id`)
) DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/* TEST DATA FOR DEBUG ONLY */
INSERT INTO `site`.`users` (`user_real_name`, `user_name`, `user_courses`, `user_password_hash`, `user_email`, `user_active`)
	VALUES ('Administrator', 'admin', 'a:1:{i:0;i:1;}', '\$2y\$15\$cDNpzTbhPCVVESl6NrvR4eBZPuqZRg9VxoS8Y4qy1D2hHemnT4e8O', 'administrator@localhost', '1');
