<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="easy, exam, management">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Management of exam submission, reviewing and grading have never been easier.">
    <title><?php echo SITE_NAME;?></title>
    <link rel="stylesheet" href="/includes/css/stylesheet.css">
    <link rel="stylesheet" href="/includes/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="/includes/vendor/twbs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/includes/vendor/twbs/bootstrap/dist/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/includes/css/prettify.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="includes/java/Jquery.js"></script>
    <script src="includes/vendor/twbs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="includes/java/prettify.js"></script>
</head>
<body onload="prettyPrint()">
  <div class="container">
  <?php include_once("includes/menu.php"); ?>
