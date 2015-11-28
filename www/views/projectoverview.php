<?php

$projectId=$_GET["id"];
$grades = ['U', 'Ux', 'G', 'A', 'B', 'C', 'D', 'E', 'Fx', 'F'];

$ssth = $dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
$ssth->execute();
$project=$ssth->fetchObject();
$submissionID = unserialize($project->submissions);

$submissionArray = array();

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
for($x = 0; $x<sizeof($submissionArray); $x++ ) {                                   //Loop for number of submissions
  if ($submissionArray[$x]->grade > 0 && $submissionArray[$x]->grade < 4){

    echo "<h2> Project plan ".($x+1)." </h2>";
    echo "Files: ".$submissionArray[$x]->files;                                 //should be serialized and linked to files.
    echo "<br>Grade: ".$grades[$submissionArray[$x]->grade-1];                  //Transforms grade using $grade array defined in the begging of the file.

  } elseif ($submissionArray[$x]->grade-1){
    echo "<h2> Project report ".($x+1)." </h2>";
    echo "Files: ".$submissionArray[$x]->files;                                 //should be serialized and linked to files.
    echo "<br>Grade: ".$grades[$submissionArray[$x]->grade-1];                  //Transforms grade using $grade array defined in the begging of the file.
  }

  }
?>


</body>
</html>
