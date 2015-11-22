<?php

// Require https
if ( $_SERVER['HTTPS'] !== 'on' ) die('Site requires https!');

// Set site variable
define('IN_EXM', TRUE);

// Activate output buffer
ob_start('ob_gzhandler');

require_once('includes/libraries/password_compatibility_library.php');

// include the config
require_once('includes/config.php');

// include the PHPMailer library
require_once('includes/libraries/PHPMailer.php');

// Include translation
include_once('includes/translations/en.php');

// includehe class autoloader
require_once('includes/autoloader.php');

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process.
$login = new Login();

// Create new database handle
$dbh = null;
try {
    // Generate a database connection, using the PDO connector
    $dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
} catch (PDOException $e) {
    // If shit hits the fan
    echo MESSAGE_DATABASE_ERROR . $e->getMessage();
    exit;
}

// Set views
$views = [
  'course',
  'overview',
  'settings',
  'edit'
];

/*
      Build the view
*/

// Is the user logged in?
if ($login->isUserLoggedIn() === true) {

  // Include header
  include_once('includes/header.php');

  if(!isset($_GET['view']))
    include('views/overview.php');
  else if (!in_array($_GET['view'], $views))
    include('views/overview.php');
  else
    include("views/$_GET[view].php");

  // Include footer
  include_once('includes/footer.php');

} else {

  // Redirect to login
  //header('Location: login.php');
  //header('Location: /Shibboleth.sso/Login');
  //print("<pre>".print_r($_SERVER,true)."</pre>");
  exit;

}
