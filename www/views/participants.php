<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canViewParticipants")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Check if user has access to this course
if (!in_array($cid, $user->getCourse())) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get current Course
$course = $user->getCourse($cid);

echo '<h4>Course Admins</h4>';
echo '<ul>';
if (empty($course->getAdmin())) {
  echo '<li>No user is assignd as admin!</li>';
} else {
  foreach ($course->getAdmin() as $key => $value) {
    $admin = $course->getAdmin($value);
    echo '<li>'.$admin->real_name.'</li>';
  }
}
echo '</ul>';
echo '<a href="?view=course&cid='.$cid.'"><button class="btn btn-default">Go back</button></a>';
