<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($cid);

echo '<div class="row">';

// List projects
echo '<div class="col-md-8">';
echo '<h2>Your projects</h2>';

$list = array();
foreach ($course->getProject() as $key => $value) {
  $project = $course->getProject($value);
  $list[] = array($project->subject, '?view=projectoverview&pid='.$project->id.'&cid='.$cid);
}
printULLink($list);
echo '</div>';


// List tasks
echo '<div class="md-col-3">';
echo '<h2>Tasks</h2>';

$list = array();
if ($user->hasPrivilege("canCreateProject")) {
  $list[] = array('Create new project', '?view=createproject&cid='.$cid);
}
if ($user->hasPrivilege("canAssignCourseAdmin")) {
  $list[] = array('Assign admin', '?view=assigncourseadmin&cid='.$cid);
}
printULLink($list);

echo '</div>';
echo '</div>';
