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
        echo "</th>Projects</th><form action=\"\" method=\"POST\"><table>";
        while($tmp = $ssth->fetchObject()){
          $rIdArray = explode(" ", unserialize($tmp->reviewers));
          for($i = 0; $i < sizeof($rIdArray); $i++){
            if($rid == $rIdArray[$i]){
              $projectName = $tmp->subject;
              echo "<tr><td>" . $projectName . "</td><td><input type=\"checkbox\" name=\"$projectName\"></td></tr>";
            }
          }
        }
        echo "<tr><td><input type=\"submit\" value=\"Submit\"></td></tr></table>";
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
  * @param array string, $subject, array containging ids of selected projects
  * @return void
  */
  function add_feasible_reviewer($rid,$dbh,$subject){
    if($dbh != null){
      for($i = 0; $i < sizeof($subject); $i++){
        $ssth = $dbh->prepare(SQL_SELECT_PROJECTS_WHERE_SUBJECT);
        $ssth->bindParam(':subject', $subject[$i], PDO::PARAM_STR);
        if($ssth->execute()){
          $tmp = $ssth->fetchObject();
          if($tmp->feasible_reviewers == null){
            $tmp->feasible_reviewers = serialize($rid);
          }
          else{
            $feasible_reviewers = unserialize($tmp->feasible_reviewers);
            $ridExist = false;
            for($j = 0; $j < sizeof($feasible_reviewers); $j++){
              if($feasible_reviewers[$j] == $rid){
                $ridExist = true;
              }
            }
            if(!$ridExist){
              $feasible_reviewers .= " " . $rid;
              $tmp->feasible_reviewers = serialize($feasible_reviewers);
            }
          }
          $ssth = $dbh->prepare(SQL_UPDATE_USER_AS_FEASIBLE_REVIEWERS_WHERE_SUBJECT);
          $ssth->bindParam(':subject', $subject[$i], PDO::PARAM_STR);
          $ssth->bindParam(':feasible_reviewers', $tmp->feasible_reviewers, PDO::PARAM_STR);
          $ssth->execut();
        }
      }
    }
    else{
      echo "DB connection has failed. Try to login.</br>";
    }
  }
