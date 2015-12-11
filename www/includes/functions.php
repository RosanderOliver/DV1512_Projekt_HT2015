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

  /**
  * @author Annika Hansson
  * @param int, $rid, variable containing reviewer id
  * @param PDO, $dbh, db connection
  * @return void
  */
  function list_projects($rid,$dbh){
    if($dbh != null){
      $ssth = $dbh->prepare(SQL_SELECT_PROJECTS);
      if($ssth->execute()){
        echo "<table></th>Projekts</th>";
        while($tmp = $ssth->fetchObject()){
          $rIdArray = explode(" ", unserialize($tmp->reviewers));
          for(int i = 0; i < sizeof($rIdArray); i++){
            if($rid == $rIdArray[i]){
              $projectName = $ssth->fetchObject($tmp->subject);
              echo "<tr><td>". $projectName . "</td></tr>";
            }
          }
        }
        echo "</table>";
      }
      else{
        echo "Somethings wrong, try to log in again.</br>";
      }
    }
    else{
      echo "DB connection has failed. Try to login.</br>";
    }
  }

  /**
  * @author Annika Hansson
  * @param PDO, $dbh, database connection
  * @param int, $rid, variable containing reviewer id
  * @param int, $projectId, variable containging id of project
  * @return void
  */
  function add_feasible_reviewer($rid,$dbh,$projectId){
    if($dbh != null){
      $ssth = $dbh->prepare(SQL_INSERT_USER_AS_FEASIBLE_REVIEWERS);
      if($ssth->execute()){
        echo "<table></th>Projekts</th>";
        while($tmp = $ssth->fetchObject()){
          $rIdArray = explode(" ", unserialize($tmp->reviewers));
          for(int i = 0; i < sizeof($rIdArray); i++){
            if($rid == $rIdArray[i]){
              $projectName = $ssth->fetchObject($tmp->subject);
              echo "<tr><td>". $projectName . "</td></tr>";
            }
          }
        }
        echo "</table>";
      }
      else{
        echo "Somethings wrong, try to log in again.</br>";
      }
    }
    else{
      echo "DB connection has failed. Try to login.</br>";
    }
  }
