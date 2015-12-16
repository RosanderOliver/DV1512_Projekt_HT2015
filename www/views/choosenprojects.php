<?php

if(isset($_GET['sid'])){
  $submissionsId = intval($_GET['sid']);
}

if(isset($_POST['submit'])){
  $temp;
  $i = 1;
  echo "Submit pressed </br>";
  foreach($_POST["ticked$i"] as $value){
    echo $value . "</br>";
  }

  echo "Done.";

}
