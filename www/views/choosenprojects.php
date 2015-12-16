<?php

if(isset($_POST['submit'])){

  $temp = $_POST['subject'];
  $reviewerId = $_SESSION['user_id'];

  echo $reviewerId;

  foreach($_POST['ticked'] as $value){
    echo $temp[$value-1] . "</br>";
    add_feasible_reviewer($reviewerId, $dbh,$temp[$value-1]);
  }

}
