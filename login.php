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
  'login',
  'password_reset',
  'register'
];

/*
      Build the view
*/

// Is the user logged in?
if ($login->isUserLoggedIn() === true) {

    // Redirect to index
    header('Location: index.php');
    exit;

} else {

    // Include header
    include_once('includes/header.php');

    if(!isset($_GET['view']))
      include("views/login.php");
    else if (!in_array($_GET['view'], $views))
      include("views/login.php");
    else
      include("views/$_GET[view].php");

    // Include footer
    include_once('includes/footer.php');
    
}
