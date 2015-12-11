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

echo "Course";

// Get current Course
$course = $user->getCourse($id);

// List projects
echo '<h2>Your projects</h2>';

echo '<ul>';
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo '<li>';
  echo '<a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a>';
  echo '</li>';
}
echo '</ul>';
