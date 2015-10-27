<?php

  // Set site variable
  define('IN_EXM', TRUE);

// check for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit('Sorry, this script does not run on a PHP version smaller than 5.3.7 !');
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once('libraries/password_compatibility_library.php');
}

// include the config
require_once('includes/config.php');

// include the PHPMailer library
require_once('includes/libraries/PHPMailer.php');

// load the login class
require_once('includes/classes/Login.php');

// load the DBM class
require_once('includes/classes/DBM.php');

// Include translation
include_once('includes/translations/en.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();

// Create new dbm
$dbm = new DBM(DB_USER, DB_PASS, DB_HOST);
$dbm->setDB(DB_NAME);

// Set views
$views = [
  'not_logged_in',
  'password_reset',
  'register',
  'course',
  'overview',
  'settings'
];

/*
      Build the view
*/

// Include header
include_once('includes/header.php');

// Is the user logged in?
if ($login->isUserLoggedIn() === true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    if(!isset($_GET['view']))
      include('views/overview.php');
    else if (!in_array($_GET['view'], $views))
      include('views/overview.php');
    else if ($_GET['view'] === 'overview')
      include('views/overview.php');

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    if(!isset($_GET['view']))
      include("views/not_logged_in.php");
    else if (!in_array($_GET['view'], $views))
      include("views/not_logged_in.php");
    else if ($_GET['view'] === 'password_reset')
      include("views/password_reset.php");
    else if ($_GET['view'] === 'register') {
      // load the registration class
      require_once('includes/classes/Registration.php');

      // create the registration object. when this object is created, it will do all registration stuff automatically
      // so this single line handles the entire registration process.
      $registration = new Registration();
      include("views/register.php");
    }
}

// Include footer
include_once('includes/footer.php');
