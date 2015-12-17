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
echo '<form action="index.php?view=assignedreviewers" method="POST">';
echo '<ul>';
// List Projects
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo "<li>" . $project->subject . "</li>";
  for($i = 0; $i < sizeof($project->feasible_reviewers);$i++){
    $reviewer = new User($project->feasible_reviewers[$i]);
    echo '<input type="checkbox" name="ticked[]" value="'.$reviewer->id.'">' .$reviewer->real_name . '</br>';
    echo '<input type="hidden" name="project[]" value="'.$project->id.'">';
  }
  echo '</ul>';
  echo '<input type="submit" name="submit" value="Submit">';
  echo '</form>';
}
