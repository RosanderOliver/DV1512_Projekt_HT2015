<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $id = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($id);

// List projects
echo '<div id="projects">';
echo '<h2>Your projects</h2>';

echo '<ul>';
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  echo '<li>';
  echo '<a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a>';
  echo '</li>';
}
echo '</ul>';
echo '</div>';


// List tasks
echo '<div id="tasks">';
echo '<h2>Tasks</h2>';
echo '<ul>';
echo   '<li>';
echo     '<a href="?view=createproject&cid='.$course->id.'">Create new project</a>';
echo   '</li>';
echo '</ul>';
echo '</div>';
