<?php

// Get course id
$cid;
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid course!");
}

// Get project id
$pid;
if (isset($_GET['pid']) && intval($_GET['pid']) > 0) {
  $pid = intval($_GET['pid']);
} else {
  exit("Invalid project!");
}

// Get the course
$course = $user->getCourse($cid);
// Get project
$project = $course->getProject($pid);

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

  if ($submission->grade >= 0 && $submission->grade < 4) {
    echo '<h2> Project plan '.($key+1).'</h2>';
  } elseif ($submission->grade > 3 && $submission->grade < 11) {
    echo '<h2> Project report '.($key+1).'</h2>';
  }
  echo 'Files: '.$submission->files;
  foreach ($comments as $key => $value) {
    echo '<br>Comment: '.$value->data;
  }
  if ($submission->grade > 0 && $submission->grade < count($grade)) {
    echo '<br>Grade: '.$grades[$submission->grade];
  } else if ($submission->grade == 0) {
    echo '<br><a href="?view=examinatorgrading&pid='.$project->id.'&sid='.$submission->id.'">Grade this submission';
  }
}
