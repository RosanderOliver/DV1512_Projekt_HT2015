<?php
$submissionArray = array();
$commentArray = array();
$projectId=$_GET["id"];

$ssth = $dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
$ssth->execute();
$project=$ssth->fetchObject();
$submissionID = unserialize($project->submissions);



for ($x=0; $x<sizeof($submissionID); $x++){

  $ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
  $ssth->bindParam(":id", $submissionID[$x], PDO::PARAM_INT);
  $ssth->execute();
  $submissionArray[$x]=$ssth->fetchObject();
}

?>


<html>
<body>

<center><h1>  Project overview  </h1></center>

<?php

for($x = 0; $x < sizeof($submissionID); $x++ ) {                                   //Loop for number of submissions

  $tempId = $submissionID[$x];
  $commentArray = getComment($dbh, $tempId);

  if ($submissionArray[$x]->grade > 0 && $submissionArray[$x]->grade < 4){      //What it is not graded? Need an else...
    echo "<h2> Project plan ".($x+1)." </h2>";
    echo "Files: ".$submissionArray[$x]->files;                                 //should be serialized and linked to files.
    echo "<br>Student comment: ".$commentArray[0];
    echo "<br>Examinator comment: ".$commentArray[1];
    echo "<br>Grade: ".$grades[$submissionArray[$x]->grade];                    //Transforms grade using $grade array defined in the begging of the file.

  } elseif ($submissionArray[$x]->grade > 3 && $submissionArray[$x]->grade < 11){                                       //Fel test?
    echo "<h2> Project report ".($x+1)." </h2>";
    echo "Files: ".$submissionArray[$x]->files;
    echo "<br>Studentv comment: ".$commentArray[0];                             //should be serialized and linked to files.
    echo "<br>Grade: ".$grades[$submissionArray[$x]->grade];                    //Transforms grade using $grade array defined in the begging of the file.
  }

  }
?>


</body>
</html>
