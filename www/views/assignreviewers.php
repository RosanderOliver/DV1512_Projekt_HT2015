<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$id;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $id = intval($_GET['id']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($id);
echo $course->name . "</br>";
echo "<ul>";
// List Projects
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo "<li>" . $project->subject . "</li>";
  for($i = 0; $i < sizeof($project->feasible_reviewers);$i++){
    $reviewer = new User($project->feasible_reviewers[$i]);
    echo $reviewer->given_name . "</br>";
  }
  echo "</ul>";
}
