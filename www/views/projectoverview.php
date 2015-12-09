<?php

// Get course id
$courseId;
if (isset($_GET['course']) && intval($_GET['course']) > 0) {
  $courseId = intval($_GET['course']);
} else {
  exit("Invalid course!");
}

// Get project id
$projectId;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $projectId = intval($_GET['id']);
} else {
  exit("Invalid project!");
}

// Get the course
$course = $user->getCourse($courseId);
// Get project
$project = $course->getProject($projectId);

echo '<h1>  Project overview  </h1>';

// List all submissions
foreach ($project->getSubmission() as $key => $value) {

  // Get the submission
  $submission = $project->getSubmission($value);
  $submission->comments = unserialize($submission->comments);
  $comments = Array();
  foreach ($submission->comments as $key => $value) {
    $comments[] = new Comment($value);
  }

  if ($submission->grade > 0 && $submission->grade < 4) {
    echo "<h2> Project plan ".($key+1)." </h2>";
    echo "Files: ".$submission->files;
    foreach ($comments as $key => $value) {
      echo "<br>Comment: ".$value->data;
    }
    echo "<br>Grade: ".$grades[$submission->grade];

  } elseif ($submission->grade > 3 && $submission->grade < 11) {
    echo "<h2> Project report ".($key+1)." </h2>";
    echo "Files: ".$submission->files;
    foreach ($comments as $key => $value) {
      echo "<br>Comment: ".$value->data;
    }
    echo "<br>Grade: ".$grades[$submission->grade];
  }
}
