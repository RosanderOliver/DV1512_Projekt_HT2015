<?php

// Don't access this script alone
if (!defined('IN_EXM')) exit;

// Check if this file already has been loaded
if (defined('CONFIG_LOADED')) exit;
// Else set it as loaded
define('CONFIG_LOADED', true);

/**
 * Configuration for: Site General Information
 * General information about the site is defined here
 *
 * SITE_DOMAIN: domain name of the site
 * SITE_NAME: name of the site/project/organization etc
 */
define("SITE_DOMAIN", "xmanager.me");
define("SITE_NAME", "Exam Manager");

/**
 * Configuration for: Database Connection
 * This is the place where database login constants are saved
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 *          by the way, it's bad style to use "root", but for development it will work.
 * DB_PASS: the password of the above user
 */
define("DB_HOST", "127.0.0.1");
define("DB_NAME", "site");
define("DB_USER", "exm");
define("DB_PASS", "cisco12345");

/**
 * Configuration for: Cookies
 * Please note: The COOKIE_DOMAIN needs the domain where your app is,
 * in a format like this: .mydomain.com
 * Note the . in front of the domain. No www, no http, no slash here!
 * For local development .127.0.0.1 or .localhost is fine, but when deploying you should
 * change this to your real domain, like '.mydomain.com' ! The leading dot makes the cookie available for
 * sub-domains too.
 * @see http://stackoverflow.com/q/9618217/1114320
 * @see http://www.php.net/manual/en/function.setcookie.php
 *
 * COOKIE_RUNTIME: How long should a cookie be valid ? 1209600 seconds = 2 weeks
 * COOKIE_DOMAIN: The domain where the cookie is valid for, like '.mydomain.com'
 * COOKIE_SECRET_KEY: Put a random value here to make your app more secure. When changed, all cookies are reset.
 */
define("COOKIE_RUNTIME", 1209600);
define("COOKIE_DOMAIN", ".".SITE_DOMAIN);
define("COOKIE_SECRET_KEY", "lk@hfsd]786@9d3NJ9{80ssfJ9");

/**
 * Configuration for: Email server credentials
 *
 * Here you can define how you want to send emails.
 * If you have successfully set up a mail server on your linux server and you know
 * what you do, then you can skip this section. Otherwise please set EMAIL_USE_SMTP to true
 * and fill in your SMTP provider account data.
 *
 * EMAIL_SG_API_KEY: API key to sendgrid account
 * @see https://app.sendgrid.com/settings/api_keys
 *
 */
define("EMAIL_SG_API_KEY", "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");

/**
 * Configuration for: password reset email data
 * Set the absolute URL to password_reset.php, necessary for email password reset links
 */
define("EMAIL_PASSWORDRESET_URL", "https://".SITE_DOMAIN."/login.php?view=password_reset");
define("EMAIL_PASSWORDRESET_FROM", "no-reply@".SITE_DOMAIN);
define("EMAIL_PASSWORDRESET_FROM_NAME", SITE_NAME);
define("EMAIL_PASSWORDRESET_SUBJECT", "Password reset for ".SITE_NAME);
define("EMAIL_PASSWORDRESET_CONTENT", "Please click on this link to reset your password:");

/**
 * Configuration for: verification email data
 * Set the absolute URL to register.php, necessary for email verification links
 */
define("EMAIL_VERIFICATION_URL", "https://".SITE_DOMAIN."/login.php?view=register");
define("EMAIL_VERIFICATION_FROM", "no-reply@".SITE_DOMAIN);
define("EMAIL_VERIFICATION_FROM_NAME", SITE_NAME);
define("EMAIL_VERIFICATION_SUBJECT", "Account activation for ".SITE_NAME);
define("EMAIL_VERIFICATION_CONTENT", "Please click on this link to activate your account:");

/**
 * Configuration for: Hashing strength
 * This is the place where you define the strength of your password hashing/salting
 *
 * To make password encryption very safe and future-proof, the PHP 5.5 hashing/salting functions
 * come with a clever so called COST FACTOR. This number defines the base-2 logarithm of the rounds of hashing,
 * something like 2^12 if your cost factor is 12. By the way, 2^12 would be 4096 rounds of hashing, doubling the
 * round with each increase of the cost factor and therefore doubling the CPU power it needs.
 * In 2013, the developers of this functions have chosen a cost factor of 10, which fits most standard
 * server setups. When time goes by and server power becomes much more powerful, it might be useful to increase
 * the cost factor, to make the password hashing one step more secure. Have a look here
 * (@see https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)
 * in the BLOWFISH benchmark table to get an idea how this factor behaves. For most people this is irrelevant,
 * but after some years this might be very very useful to keep the encryption of your database up to date.
 *
 * Remember: Every time a user registers or tries to log in (!) this calculation will be done.
 * Don't change this if you don't know what you do.
 *
 * To get more information about the best cost factor please have a look here
 * @see http://stackoverflow.com/q/4443476/1114320
 *
 * This constant will be used in the login and the registration class.
 */
define("HASH_COST_FACTOR", "12");

/**
 * Configuration for: Paths
 * Defines paths to important parts of the application
 *
 * PATH_CLASS: path to folder contatning all classes
 */
 define("PATH_CLASS", "includes/classes/");

 /**
  * Configuration for: maximum lengths
  * Defines maximum lengths of data variables, this is limited by the database
  *
  * MAX_COMMENT_LENGTH: Maximum length allowed in the database
  * MAX_COMMENT_DEPTH: maximum printed depth of comments and responses to comments
  * MAX_PROJECT_SUBJECT_LENGTH: Maximum length allowed in the database
  * MAX_COURSE_NAME_LENGTH: Maximum length allowed in the database
  */
  define("MAX_COMMENT_LENGTH", 256);
  define("MAX_COMMENT_DEPTH", 3);
  define("MAX_PROJECT_SUBJECT_LENGTH", 64);
  define("MAX_COURSE_NAME_LENGTH", 64);

  /**
   * Configuration for: project stages
   * Defines stages for the project
   *
   * STAGE_DRAFT: project is newly created and waiting for approval
   * STAGE_PLAN: project plan needs to be submitted
   * STAGE_RAPPORT: project rapport needs to be submitted
   * STAGE_PEER_REVIEW: project is waiting to be reviewd by a Peer
   * STAGE_FINISHED: project is finished and can't be edited
   */
   define("STAGE_DRAFT", "Draft");
   define("STAGE_PLAN", "Plan");
   define("STAGE_REPORT", "Report");
   define("STAGE_PEER_REVIEW", "Peer Review");
   define("STAGE_FINISHED", "Finished");
