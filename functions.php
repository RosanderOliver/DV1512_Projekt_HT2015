<?php

/*Test of grade

Tests if $data is a valid grade. If not the varible is set to "".

@parameters    takes one field that is a grade
@returnvalue   returns $data as grade or blank
*/
function test_grade($data){
  if($data == "G" || $data == "UX" || $data == "U"){
    return $data;
  }
  else if($data == "A" || $data == "B" || $data == "C" || $data == "D" || $data == "E" || $data == "F" || $data == "FX"){
    return $data;
  }
  else {
    $data = "";
    return $data;
  }
}

/*Test of number

Tests if $data is in the range of 1-5 or "-", else it returns 0.

@parameters    takes one field that is a number
@returnvalue   returns $data as valid number
*/
function test_num($data){
  if($data < 0 || $data > 5 || $data == "-"){
    $data = "-";
    return $data;
  }
  else{
    return $data;
  }
}

/* Test of input

Tests and strips the data if attempts to hack are made.

@parameters   takes one field of data
@reurnvalue   returns the $data with no extra characters
*/
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


 ?>
