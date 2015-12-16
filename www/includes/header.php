<?php

  // Don't access this script alone
  if (!defined('IN_EXM')) exit;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="keywords" content="easy, exam, management">
    <meta name="description" content="Management of exam submission, reviewing and grading have never been easier.">
    <title>Exam Manger</title>
    <link rel="stylesheet" href="/includes/css/stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="includes/java/Jquery.js"></script>
</head>
<body onresize="pageSize()" onload="prettyprint()">
  <?php include_once("includes/menu.php"); ?>
  <div id="page">
