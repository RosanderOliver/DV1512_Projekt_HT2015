<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canSelectProjectsToReview")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($cid);
if($course->select_project == 0){
  echo "<h2>Projects to review</h2></br>";
  echo "<ul>";
  foreach($course->getProject() as $key => $value){
    $project = $course->getProject($value);
    for($i = 0; $i < sizeof($project->reviewers); $i++){
      if($project->reviewers[$i] == $user->id){
        echo '<li><a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a></li>';
      }
    }
  }
  echo "</ul>";
}else if($course->select_project == 1) {
  // List projects
  echo '<h2>Select projects</h2>';
  echo '<form action="index.php?view=selectedprojects" method="POST">';
  echo '<ul>';
  foreach ($course->getProject() as $key => $value) {
    $project = $course->getProject($value);
    echo '<li>';
    echo '<a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a> <input type="checkbox" name="ticked[]" value="'.$value.'">';
    echo '<input type="hidden" name="pid[]" value="'.$project->id.'">';
    echo '</li>';
  }
  echo '</ul>';
  echo '<input type="submit" name="submit" value="Submit">';
  echo '</form>';
}
