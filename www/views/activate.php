<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canViewAllProjects")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

$course = $user->getCourse($cid);
$course->setActiveCourse();

$url = '?view=course&cid='.$cid;

header('Location:'.$url);
