<?php

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canSelectProjectsToReview")) {
  header("Location: ?view=accessdenied");
  exit();
}

if(isset($_POST['submit'])){

  $temp = $_POST['pid'];

  if(isset($_POST['ticked'])){
    foreach($_POST['ticked'] as $value){
      $project = new Project($value);
      $project->addFeasibleReviewer();
    }
  }

  echo "Choices submitted.</br>";

}
