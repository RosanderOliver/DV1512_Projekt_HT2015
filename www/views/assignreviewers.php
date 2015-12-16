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
echo '<form metod="POST" action="?view=assignedreviewers"><ul>';

// List Projects
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo "<li>" . $project->subject . "</li>";
  for($i = 0; $i < sizeof($project->feasible_reviewers);$i++){
    $reviewer = new User($project->feasible_reviewers[$i]);
    echo '<input type="checkbox" name="'.$project->id.'" value="'.$reviewer->id.'">'.$reviewer->real_name . "</br>";
  }
  echo '</ul><input type="submit" name="submit" value="Submit"></form>';
}
