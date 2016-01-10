<?php

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
