<?php

// TODO Test permissions..
// TODO Plz comment..

if(isset($_POST['submit'])){

  $pid = $_POST['project'];
  $rid = $_POST['ticked'];

if(sizeof($rid) != 0){
    if(isset($_POST['ticked'])){
      foreach($_POST['ticked'] as $key => $value){
        $project = new Project($pid[$key]);
        $project->addReviewer($rid[$key]);
      }
    }
  }

  echo "Choices submitted.</br>";

}
