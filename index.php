<?php

  // Set site variable
  define('IN_PR', TRUE);

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

// Include translation
include_once('includes/translations/en.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();

// Include header
include_once('includes/header.php');

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("views/logged_in.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    if(!isset($_GET['view']))
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
