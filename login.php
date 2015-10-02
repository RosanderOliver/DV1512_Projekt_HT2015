<?php

  $username = $_POST["name"];


  //Starting the session
  session_start();
  $_SESSION['username'] = $username;

  //Lets redirect them to the proper location
  if ($username  == "admin")
    header("Location: ./overview.php");
  elseif ($username == "user")
    header("Location: ./overview.php");
  elseif ($username == "reviewer")
    header("Location: ./overview.php");

  die(); //Think this kill the page if the ridirect did not work.



?>
