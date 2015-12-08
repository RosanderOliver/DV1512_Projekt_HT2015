<?php

// Get course id
$course;
if (isset($_GET['course']) && intval($_GET['course']) > 0) {
  $course = intval($_GET['course']);
} else {
  exit("Invalid course!");
}

// Get project id
$project;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $project = intval($_GET['id']);
} else {
  exit("Invalid project!");
}

// Get the course
$course = $user->getCourse($course);
// Get project
$project = $course->getProject($project);

echo '<h1>  Project overview  </h1>';

// List all submissions
foreach ($project->submissions as $key => $value) {

  // Get the submission
  $sth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
  $sth->bindParam(":id", $value, PDO::PARAM_INT);
  $sth->execute();
  $submission = $sth->fetch(PDO::FETCH_OBJ);

  //$commentArray = getComment($dbh, $submission->id);

  if ($submission->grade > 0 && $submission->grade < 4){      //What it is not graded? Need an else...
    echo "<h2> Project plan ".($key+1)." </h2>";
    echo "Files: ".$submission->files;                                 //should be serialized and linked to files.
    //echo "<br>Student comment: ".$commentArray[0];
    //echo "<br>Examinator comment: ".$commentArray[1];
    echo "<br>Grade: ".$grades[$submission->grade];                    //Transforms grade using $grade array defined in the begging of the file.

  } elseif ($submission->grade > 3 && $submission->grade < 11){                                       //Fel test?
    echo "<h2> Project report ".($key+1)." </h2>";
    echo "Files: ".$submission->files;
    //echo "<br>Studentv comment: ".$commentArray[0];                             //should be serialized and linked to files.
    echo "<br>Grade: ".$grades[$submission->grade];                    //Transforms grade using $grade array defined in the begging of the file.
  }
}
