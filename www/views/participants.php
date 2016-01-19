<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canViewParticipants")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get current Course
$course = $user->getCourse($cid);

echo '<div class="col-md-6">';

// Admins
echo '<ul class="list-group">';
echo '<li class="list-group-item"><b>Course Admins</b></li>';
// The admin user is an implicit admin for all courses and should therefor not be printed
if (empty($course->getAdmin()) || $course->getAdmin() == Array(1)) {
  echo '<li class="list-group-item">No user is assigned as admin!</li>';
} else {
  foreach ($course->getAdmin() as $key => $value) {
    if ($value != 1) {
      $admin = $course->getAdmin($value);
      echo '<li class="list-group-item">'.$admin->real_name.'</li>';
    }
  }
}
echo '</ul>';

// Examinators
echo '<ul class="list-group">';
echo '<li class="list-group-item"><b>Examinators</b></li>';
if (empty($course->getExaminator())) {
  echo '<li class="list-group-item">No examinator is assigned to this course!</li>';
} else {
  foreach ($course->getExaminator() as $key => $value) {
    $examinator = $course->getExaminator($value);
    echo '<li class="list-group-item">'.$examinator->real_name.'</li>';
  }
}
echo '</ul>';

// Reviewers
echo '<ul class="list-group">';
echo '<li class="list-group-item"><b>Reviewers</b></li>';
if (empty($course->getReviewer())) {
  echo '<li class="list-group-item">No reviewer is assigned to this course!</li>';
} else {
  foreach ($course->getReviewer() as $key => $value) {
    $reviewer = $course->getReviewer($value);
    echo '<li class="list-group-item">'.$reviewer->real_name.'</li>';
  }
}
echo '</ul>';

// All users
echo '<ul class="list-group">';
echo '<li class="list-group-item"><b>Users</b></li>';
if (empty($course->getUser())) {
  echo '<li class="list-group-item">No user is assigned to this course!</li>';
} else {
  foreach ($course->getUser() as $key => $value) {
    $user = $course->getUser($value);
    echo '<li class="list-group-item">'.$user->real_name.'</li>';
  }
}
echo '</ul>';

echo '<a href="?view=course&cid='.$cid.'"><button class="btn btn-default">Go back</button></a>';

echo '</div>';
