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
    echo '<nav>';
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
    if ($list == null || $list == array()) {
      return;
    }

    echo '<ul>';
    foreach ($list as $key => $set) {

      $label = $set[0];
      if (isset($set[1])) {
        $value = $set[1];
      }
      else {
        $value = null;
      }

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

  /**
  * Set data in database with currentdate and time
  * @author Oliver Rosander
  * @param int $user, string $comment, string $subcomment, PDO $dbh
  * @return int Id of inserted row, -1 if fail
  */
  function setComment($user, $comment, $subcomment, $dbh) {
    $date = date("Y-m-d H:i:s");
    $ssth = $dbh->prepare(SQL_INSERT_COMMENT);
    $ssth->bindParam(":user", $user, PDO::PARAM_INT);
    $ssth->bindParam(':date', $date, PDO::PARAM_STR);
    $ssth->bindParam(":data", $comment, PDO::PARAM_STR);
    $ssth->bindParam(":subcomments", $subcomment, PDO::PARAM_STR);
    $ssth->execute();
    return intval($dbh->lastInsertId());
  }

  /**
  * createComment that uses setComment to insert into database.
  * @author Oliver Rosander
  * @param PDO $dbh, string|null $lbl Post index default "comment"
  * @return int Id of last inserted row -1 if fail
  */
  function createComment($dbh, $lbl = null) {
    // Check for label to retrieve data from session
    if ($lbl == null && isset($_POST["comment"])) {
      $comment = $_POST["comment"];
    } elseif (isset($_POST[$lbl])) {
      $comment = $_POST[$lbl];
    }
    else {
      return -1;
    }
    // Check data
    if ($comment != null && strlen($comment) < 256) {
      $comment = strip_tags($comment);
      $subcomments = serialize(array());
      $ret = setComment(0, $comment, $subcomments, $dbh);                       //TODO MISSING USER AND SUBCOMMENT
      if ($ret != -1) {
        return $ret;
      } else {
        return -1;
      }
    } else {
      return -1;
    }
  }

/**
 * getComment Retrives comments given a submission id
 * @author Oliver Rosander
 * @param PDO $dbh
 * @param int $subId
 * @return array -1 if fail or an array containing the comments
 */
 function getComment($dbh, $subId) {
   $commentIdArr = array();
   $commentArr = array();

   $ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
 	 $ssth->bindParam(":id", $subId, PDO::PARAM_INT);								              //TODO is it just one fileid, otherwise handle it
   $ssth->execute();
   $submission = $ssth->fetchObject();
   $commentIdArr = unserialize($submission->comments);

   for ($x=0; $x<sizeof($commentIdArr); $x++) {

     $ssth = $dbh->prepare(SQL_SELECT_COMMENTS_WHERE_ID);
     $ssth->bindParam(":id", $commentIdArr[$x], PDO::PARAM_INT);
     $ssth->execute();
     $comments = $ssth->fetchObject();
     $commentArr[$x] = $comments->data;
  }
  return $commentArr;
 }

  /**
  * Test of grade
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
    if(($data < 0 || $data > 6) || $data === "-"){
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

  /**
  * Insert review id into submissions
  * @author Oliver Rosander
  * @param PDO $dbh, int $submissionsId, int $lastInsertId
  * @return -1 if fail otherwise lastInsertId
  */
  function insertReviewIdToSubmission($dbh, $submissionsId, $lastInsertId) {
    $ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
   	$ssth->bindParam(":id", $submissionsId, PDO::PARAM_INT);
    $ssth->execute();
    $submission = $ssth->fetchObject();
    $lastInsertId = intval($lastInsertId);
    if ($submission->reviews == null) {
      $reviewIdArr[] = $lastInsertId;
      $submission->reviews = serialize($reviewIdArr);
    } else{
      $reviewIdArr = unserialize($submission->reviews);
      $reviewIdArr[] = $lastInsertId;
      $submission->reviews = serialize($reviewIdArr);
    }
    $ssth = $dbh->prepare(SQL_UPDATE_SUBMISSION_REVIEWS_WHERE_ID);
    $ssth->bindParam(":reviews", $submission->reviews, PDO::PARAM_STR);
    $ssth->bindParam(":id", $submissionsId, PDO::PARAM_INT);
    $ssth->execute();
  }

  /**
   * @author Annika Hansson
   * @var
   * @param string, $data, class variable
   * @return string, return true if a class variable is empty
   */
  function is_empty($data) {
   return empty($data);
  }

  /**
  * @author Annika Hansson
  * @var
  * @param string, $data, raw data from form
  * @return string, returned with a size of 3 or 0
  */
  function length_three($data){
    if(sizeof($data) > 3){
      $diff = 3 - sizeof($data);
      $rest = substr($data, 0, $diff);
      $data = $rest;
    }
    else if(sizeof($data) < 0){
      $data = "";
    }
    return $data;
  }

  /**
 * @author Annika Hansson
 * @var
 * @param string, $data, raw data from form
 * @return string, returned with a size of 10 or 0
 */
 function length_date($data){
   if(strlen($data) > 10){
     $diff = 10 - strlen($data);
     $rest = substr($data, 0, $diff);
     $data = $rest;
   }
   else if(strlen($data) < 0){
     $data = "";
   }
   return $data;
 }

 /**
  * @author Annika Hansson
  * @var
  * @param string, $data, raw data from form
  * @return string, returned with a size of 1 or 0
  */
  function length_one($data){
    if(strlen($data) != 1){
      $diff = 1 - strlen($data);
      $rest = substr($data, 0, $diff);
      $data = $rest;
    }
    return $data;
  }

  /**
  * @author Annika Hanssonstrlen
  * @var
  * @param string, $data, raw data from form
  * @return string, returned with a size that does not exceed the limit of 128 chars
  */
  function input_length($data){
    if(strlen($data) > 128){
      $diff = 128 - strlen($data);
      $rest = substr($data, 0, $diff);
      $data = $rest;
    }
    else if(strlen($data) < 0){
      $data = "";
    }
    return $data;
  }

  /**
  * @author Oliver Rosander, Jim Ahlstrand
  * @param PDO $dbh
  * @return int, id of last input
  * @see define("SQL_INSERT_SUBMISSION", "INSERT INTO `site`.`submissions` (`user`, `date`, `files`, `reviews`, `comments`, `grade`, `stage`) VALUES (:user, :date, :files, :reviews, :comments, :grade, :stage)");
  */
  function createEmptySubmission($dbh) {
    // TODO These should be input parameters
    $user = 0;
    $grade = 0;
    $stage = 0;
    // =============
    $date = date("Y-m-d H:i:s");
    $files = serialize(array());
    $reviews = serialize(array());
    $comments = serialize(array());
    $sth = $dbh->prepare(SQL_INSERT_SUBMISSION);                               //TODO Deadlines borde sättas här!
    $sth->bindParam(":user", $user, PDO::PARAM_INT);
    $sth->bindParam(':date', $date, PDO::PARAM_STR);
    $sth->bindParam(":files",$files, PDO::PARAM_STR);
    $sth->bindParam(":reviews", $reviews, PDO::PARAM_STR);
    $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
    $sth->bindParam(":grade", $grade, PDO::PARAM_INT);
    $sth->bindParam(":stage", $stage, PDO::PARAM_INT);
    $sth->execute();

    return intval($dbh->lastInsertId());
  }

  /** CreateTable
  * @author Oliver Rosander, Jim Ahlstrand
  * @param string array containing the column names
  * @param string array containing the table data
  */
  function printTable( $head = null, $data )
  {
    echo '<table width=700px>';
    // If head
    if($head != null)
    {
      echo '<thead>';
      echo '<tr>';
      foreach ($head as $key => $value) {
        echo '<td>'.$value.'</td>';
      }
      echo '</tr>';
      echo '</thead>';
    }
    echo '<tdata>';
    // for each row
    foreach ($data as $key => $row) {
      // for each column
      echo '<tr>';
      foreach ($row as $key2 => $column) {
        echo '<td>'.$column.'</td>';
      }
      echo '</tr>';
    }
    echo '</tdata>';
    echo '</table>';
  }
