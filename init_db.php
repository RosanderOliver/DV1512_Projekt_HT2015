<?php

  // Database file
  // Here we define functions to initialize database

  // TODO
  // Seperate data storage and data handling, tables to store data and metadata and tables to link that data together
  // Move project stage to files?
  // Create projects database to handle projects and let courses and files etc store data
  // Move deadlines to files or stated above projects?
  // Filetypes?
  // Add searched for viruses bool in files
  // Move file grading to projects or some other handler
  // Move file written reviews to some handler

  // Set site variable
  define('IN_EXM', TRUE);
  //if (!defined(IN_PR)) exit;

  require_once("includes/config.php");

  // Create new dbh
  $dbh = null;
  try {
      // Generate a database connection, using the PDO connector
      $dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
  } catch (PDOException $e) {
      // If shit hits the fan
      echo MESSAGE_DATABASE_ERROR . $e->getMessage();
      exit;
  }

  // Create database site
  $dbh->exec("CREATE DATABASE IF NOT EXISTS `site`;")  or die(print_r($dbh->errorInfo(), true));

  // Users
  $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`users` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id, unique',
      `eppn`                  VARCHAR(16)   NOT NULL UNIQUE COMMENT 'user''s identifier, unique',
      `user_email`            VARCHAR(64)   NOT NULL UNIQUE COMMENT 'user''s email, unique',
      `user_name`             VARCHAR(64)   NOT NULL COMMENT 'user''s real name',
      `courses`               VARCHAR(32)   NOT NULL DEFAULT 'a:0:{}' COMMENT 'serialized array with user''s enlisted courses',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user specific data like email and unique identifier';") or die(print_r($dbh->errorInfo(), true));

  // Courses
  $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`courses` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
      `role_table`            INT           NOT NULL COMMENT 'table of permissions id',
      `deadlines`             VARCHAR(64)   NOT NULL COMMENT 'array with the course''s dates for dealines',
      `projects`              VARCHAR(128)  NOT NULL DEFAULT 'a:0:{}' COMMENT 'files assosiated with the course',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='course roles, files and other data related to each course';") or die(print_r($dbh->errorInfo(), true));

   // Projects
   $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`projects` (
     `id`                     INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
     `subject`                VARCHAR(64)   NOT NULL COMMENT 'title of the project',
     `stage`                  INT           NOT NULL DEFAULT 0 COMMENT 'stage of project ex start and finished',
     `grade`                  INT           NOT NULL DEFAULT -1 COMMENT 'grade of the file',
     `deadline`               DATETIME      NOT NULL COMMENT 'next deadline for the project',
     `students`               VARCHAR(64)   NOT NULL COMMENT 'students linked to the project',
     `managers`               VARCHAR(64)   NOT NULL DEFAULT 'a:0:{}' COMMENT 'managers linked to the project',
     `examinators`            VARCHAR(64)   NOT NULL COMMENT 'examinators linked to the project',
     `reviewers`              VARCHAR(64)   NOT NULL DEFAULT 'a:0:{}' COMMENT 'reviewers linked to the project',
     PRIMARY KEY (`id`)
  ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='data about all uploaded files';") or die(print_r($dbh->errorInfo(), true));

  // Files
  $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`files` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
      `type`                  VARCHAR(64)   NOT NULL COMMENT 'Filetype',
      `user`                  INT           NOT NULL COMMENT 'user id of the uploader',
      `date`                  DATETIME      NOT NULL DEFAULT NOW() COMMENT 'date and time of the upload',
      `path`                  VARCHAR(64)   NOT NULL COMMENT 'relative path to the file',
      `comments`              VARCHAR(128)  NOT NULL DEFAULT 'a:0:{}' COMMENT 'array with id''s of comments',
      `reviews`               VARCHAR(64)   NOT NULL DEFAULT 'a:0:{}' COMMENT 'array with written reviews for the file',
      `grade`                 INT           NOT NULL DEFAULT -1 COMMENT 'grade of the file',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='data about all uploaded files';") or die(print_r($dbh->errorInfo(), true));

  // Comments
  $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`comments` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
      `user`                  INT           NOT NULL COMMENT 'id of user submitting the comment',
      `date`                  DATETIME      NOT NULL DEFAULT NOW() COMMENT 'date and time of submission',
      `data`                  VARCHAR(256)  NOT NULL COMMENT 'content of comment',
      `subcomments`           VARCHAR(64)   NOT NULL DEFAULT 'a:0:{}' COMMENT 'array with id''s of subcomments',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='data about comments';") or die(print_r($dbh->errorInfo(), true));

  // Reviews
  $dbh->exec("CREATE TABLE IF NOT EXISTS `site`.`reviews` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
      `user`                  INT           NOT NULL COMMENT 'id of user submitting the review',
      `date`                  DATETIME      NOT NULL DEFAULT NOW() COMMENT 'date and time of submission',
      `last_modified`         DATETIME      NOT NULL DEFAULT NOW() COMMENT 'date of last modification',
      `comments`              VARCHAR(128)  NOT NULL DEFAULT 'a:0:{}' COMMENT 'array with id''s of comments',
      `data`                  VARCHAR(8192) NOT NULL COMMENT 'content of review',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='data from and about forms submitted by reviewers';") or die(print_r($dbh->errorInfo(), true));

  // Create database permissions
  $dbh->exec("CREATE DATABASE IF NOT EXISTS `permissions`;") or die(print_r($dbh->errorInfo(), true));

  // Course-admins
  $dbh->exec("CREATE TABLE IF NOT EXISTS `permissions`.`course_admins` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',
      `user`                  INT           NOT NULL COMMENT 'id of the user',
      `can_create_courses`    TINYINT       NOT NULL DEFAULT 1 COMMENT 'can the user create new courses?',
      `can_archive_courses`   TINYINT       NOT NULL DEFAULT 1 COMMENT 'can the user archive/inactivate courses?',
      `can_delete_courses`    TINYINT       NOT NULL DEFAULT 1 COMMENT 'can the user delete courses?',
      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='list of users with special privileges';") or die(print_r($dbh->errorInfo(), true));


  // Create template database
  $dbh->exec("CREATE DATABASE IF NOT EXISTS `templates`;") or die(print_r($dbh->errorInfo(), true));

  // Course permission template table
  /*
  $dbh->exec("CREATE TABLE IF NOT EXISTS `permissions`.`course_admins` (
      `id`                    INT           NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing id',

      PRIMARY KEY (`id`)
   ) AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='list of users with special privileges';")
   or die(print_r($dbh->errorInfo(), true));
  */
// FOR TESTING ONLY ---------------------------------------------------------------------------------------------------------------------
  // Create database login
  $dbh->exec("CREATE DATABASE IF NOT EXISTS `login`;") or die(print_r($dbh->errorInfo(), true));

  // Create table users
  $dbh->exec("CREATE TABLE IF NOT EXISTS `login`.`users` (
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
              ) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';") or die(print_r($dbh->errorInfo(), true));

  // Add test admin user
  $dbh->exec("INSERT INTO `login`.`users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `user_active`)
    VALUES ('1', 'admin', '\$2y\$15\$cDNpzTbhPCVVESl6NrvR4eBZPuqZRg9VxoS8Y4qy1D2hHemnT4e8O', 'student@localhost', '1');") or die(print_r($dbh->errorInfo(), true));
