<?php

if(isset($_GET['sid'])){
  $submissionsId = intval($_GET['sid']);
}

if(isset($_POST['submit'])){
  $temp;
  $i = 0;
  while($_POST["ticked'.$i'"]){
    $temp = "ticked'.$i.'";
    add_feasible_reviewer($submissionsId,$dbh,$temp);
    $i++;
  }

  echo "Done.";

}
