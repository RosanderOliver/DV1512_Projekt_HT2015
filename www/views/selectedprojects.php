<?php

if(isset($_POST['submit'])){

  $temp = $_POST['subject'];
  $reviewerId = $_SESSION['user_id'];

  if(isset($_POST['ticked'])){
    foreach($_POST['ticked'] as $value){
      add_feasible_reviewer($reviewerId, $dbh,$temp[$value-1]);
    }
  }

  echo "Choices submitted.</br>";

}
