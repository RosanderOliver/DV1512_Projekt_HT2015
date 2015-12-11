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
foreach (array_reverse($project->getSubmission()) as $key => $value) {

  // Get the submission
  $submission = new Submission($value);

  foreach ($submission->comments as $key => $value) {
    $comments[] = new Comment($value);
  }

  if ($stages[$submission->stage] == STAGE_PLAN) {
    echo '<h2> Project plan</h2>';
  } elseif ($stages[$submission->stage] == STAGE_REPORT) {
    echo '<h2> Project report</h2>';
  }
  echo 'Files: '.$submission->files;
  foreach ($comments as $key => $value) {
    echo '<br>Comment: '.$value->data;
  }
  if ($submission->grade > 0 && $submission->grade < count($grades)) {
    echo '<br>Grade: '.$grades[$submission->grade];
  } else if ($submission->grade == 0) {
    echo '<br><a href="?view=examinatorgrading&pid='.$project->id.'&sid='.$submission->id.'">Grade this submission</a>';
    if ($submission->userHasReviewed()) {
      echo '<br><a href="?view=projectreviews&sid='.$submission->id.'">View reviews</a>';
    } else if ($stages[$submission->stage] == STAGE_PLAN) {
      echo '<br><a href="?view=reviewplan&sid='.$submission->id.'">Review this submission</a>';
    } else if ($stages[$submission->stage] == STAGE_REPORT) {
      echo '<br><a href="?view=reviewthesis&sid='.$submission->id.'">Review this submission</a>';
    }
  }
}
