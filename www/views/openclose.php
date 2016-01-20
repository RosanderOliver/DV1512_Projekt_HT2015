<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canToggleReviewSelection")) {
  header("Location: ?view=accessdenied");
  exit();
}


$course = $user->getCourse($cid);
$course->setSelectProject();

$url = '?view=course&cid='.$cid;

header('Location:'.$url);
