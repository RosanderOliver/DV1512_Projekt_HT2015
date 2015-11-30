<?php

  // Functions file
  // Here we define functions used in the project

  // Don't access this script alone
<<<<<<< HEAD

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
=======
  if (!defined('IN_EXM')) exit;


  /**
  * Print Menu
  * Prints a html menu
  * @author Jim Ahlstrand
  * @param  array  $navigation  An array containing the items and subitems
  * @return void
  */
  function printMenu($navigation) {
    echo '<nav id="menu">';
    printULLink( $navigation );
    echo '</nav>';
  }

  /**
  * Print Unordered list with links
  * Prints an unordered list recursively
  * @author Jim Ahlstrand
  * @param  array  $list   An array containing the label and value
  * @return void
  */
  function printULLink( $list ) {
    echo '<ul>';
    foreach ($list as list($label, $value)) {
      echo '<li>';
      if (is_array($value)) {
        echo "<a href=\"#\">$label</a>";
        printULLink($value);
      } else {
        echo "<a href=\"$value\">$label</a>";
      }
      echo '</li>';
    }
    echo '</ul>';
  }

  /**
  * Pretty data dump
  * @author Jim Ahlstrand
  * @param  array|object  $var   An array or pbject with data to print
  * @return void
  */
  function prettyPrint($var) {
    print '<pre>'; print_r($var); print '</pre>';
>>>>>>> 94ffa298fcf7a13d50d1ee58d39b9d94d25e5348
  }
