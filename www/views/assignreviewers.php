<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canAssignReviewers")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get current Course
$course = $user->getCourse($cid);

echo $course->name . "</br>";
echo '<form action="index.php?view=assignedreviewers" method="POST">';
echo '<ul>';
// List Projects
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo "<li>" . $project->subject . "</li>";
  for($i = 0; $i < sizeof($project->feasible_reviewers);$i++){
    $reviewer = new User($project->feasible_reviewers[$i]);
    echo '<input type="checkbox" name="ticked[]" value="'.$reviewer->id.'">' .$reviewer->real_name. '</br>';
    echo '<input type="hidden" name="project[]" value="'.$project->id.'">';
  }
}
echo '</ul>';
echo '<input type="submit" name="submit" value="Submit">';

echo '</form>';
