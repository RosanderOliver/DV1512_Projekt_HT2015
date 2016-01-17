<?php

// Get course id
$cid = getCID();

// Get project id
if (isset($_GET['pid']) && intval($_GET['pid']) > 0) {
  $pid = intval($_GET['pid']);
} else {
  exit("Invalid project!");
}

// Get the course
$course = $user->getCourse($cid);
// Get project
$project = $course->getProject($pid);

echo '<div class="row">';
echo '<div class="col-md-3">';
echo '<h2>  Project overview  </h2>';

// List all submissions
foreach (array_reverse($project->getSubmission()) as $key => $value) {

  // Get the submission
  $submission = new Submission($value);

  echo '<h4>'.$stages[$submission->stage].'</h4>';
  echo 'Date: '.$submission->date->format('Y-m-d H:i');

  foreach ($submission->getComments() as $key => $value) {
    echo '</br>Comment: '.$value->data;
  }
  if ($submission->grade > 0 && $submission->grade < count($grades)) {
    echo '</br>Grade: '.$grades[$submission->grade];
  } else if ($submission->grade == 0) {
    if($user->hasPrivilege("canGradeProjects")){
      echo '<br><a href="?view=examinatorgrading&pid='.$project->id.'&sid='.$submission->id.'">Grade this submission</a>';
    }
    if ($submission->userHasReviewed()) {
      echo '<br><a href="?view=projectreviews&sid='.$submission->id.'">View reviews</a>';
    }
    if ($stages[$submission->stage] == STAGE_PLAN && $user->hasPrivilege("canReview")) {
      echo '<br><a href="?view=reviewplan&sid='.$submission->id.'">Review this submission</a>';
    } else if ($stages[$submission->stage] == STAGE_REPORT && $user->hasPrivilege("canReview")) {
      echo '<br><a href="?view=reviewthesis&sid='.$submission->id.'">Review this submission</a>';
    }
  }

  echo '<hr/>';
}

echo '</div>';
echo '</div>';
