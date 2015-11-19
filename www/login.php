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

// Include translation
include_once('includes/translations/en.php');

// Create a login object.
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
