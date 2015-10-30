<?php

// Set site variable
define('IN_EXM', TRUE);

require_once('includes/libraries/password_compatibility_library.php');

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
      include("views/register.php");
    }
}

// Include footer
include_once('includes/footer.php');
