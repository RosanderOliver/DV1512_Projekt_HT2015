<?php
  // Functions file
  // Here we define functions used in the project
  // Don't access this script alone
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
  }

  
  /**Test of grade
  * @author Annika Hansson
  * @param string, $data, raw data from form
  * @return string, returned as a valid grade
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

  /**
  * @author Annika Hansson
  * @var
  * @param int, $data, raw data from form
  * @return int, returned as valid number
  */
  function test_num($data){
    if(($data < 0 && $data > 6) || $data == "-"){
      $data = "-";
      return $data;
    }
    else{
      return $data;
    }
  }

  /**
  * @author Annika Hansson
  * @var
  * @param string, $data, raw data from form
  * @return string, returned without specialcharacters and backslashes
  */
  function test_input($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  /** Insert review id into submissions
   * @author Oliver Rosander
   * @param PDO $dbh, int $submissionsId, int $lastInsertId
   * @return -1 if fail otherwise lastInsertId
   */
   function insertReviewIdToSubmission($dbh, $submissionsId, $lastInsertId) {

     $ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
   	 $ssth->bindParam(":id", $submissionsId, PDO::PARAM_INT);
     $ssth->execute();
     $submission = $ssth->fetchObject();

     if ($submission->reviews == null) {
       $submission->reviews = serialize($lastInsertId);
     } else{
       $reviewIdArr = unserialize($submission->reviews);
       $reviewIdArr .=" ".$lastInsertId;
       $submission->reviews = serialize($reviewIdArr);
     }

     $ssth = $dbh->prepare(SQL_UPDATE_SUBMISSION_REVIEWS_WHERE_ID);
     $ssth->bindParam(":reviews", $submission->reviews, PDO::PARAM_STR);
     $ssth->bindParam(":id", $submissionsId, PDO::PARAM_INT);
     $ssth->execute();

   }
