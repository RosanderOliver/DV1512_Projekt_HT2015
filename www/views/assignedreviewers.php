<?php

if(isset($_POST['submit'])){

  $pid = $_POST['project'];
  $rid = $_POST['ticked'];

if(sizeof($rid) != 0){
    if(isset($_POST['ticked'])){
      foreach($_POST['ticked'] as $value){
        echo $pid[$value-1];
        $project = new Project($pid[$value-1]);
        $project->addReviewer($rid[$value-1]);
      }
    }
  }

  echo "Choices submitted.</br>";

}
