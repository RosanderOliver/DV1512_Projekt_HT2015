<?php

  // Functions file
  // Here we define functions used in the project

  // Don't access this script alone

  //if (!defined('IN_EXN')) exit;


  /*Test of grade

  Tests if $data is a valid grade. If not the varible is set to "".

  @author Annika Hansson
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

  @author Annika Hansson
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

  @author Annika Hansson
  @reurnvalue   returns the $data with no extra characters
  */
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
