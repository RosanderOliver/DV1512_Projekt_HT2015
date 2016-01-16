<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

echo '<div class="row">';

echo '<div class="col-md-8">';
echo '<h2>Active Courses</h2>';
echo '<ul>';

foreach ($user->getCourse() as $key => $value) {
  $course = $user->getCourse($value);
  if($course->active == 1){
    echo '<li>';
    echo '<a href="?view=course&cid='.$course->id.'">'.$course->name."</a>";
    echo '</li>';
  }
}

echo '</ul>';
echo '</div>';

// List tasks
echo '<div class="col-md-3">';
echo '<h2>Tasks</h2>';
$list = array();
if ($user->hasPrivilege("canCreateCourse")) { //admin
  $list[] = array('Create new course', '?view=createcourse');
}
if ($user->hasPrivilege("canViewPermissions")) { //admin
  $list[] = array('View permissions', '?view=permissions');
}
printULLink($list);
echo '</div>';

echo '</div>';
