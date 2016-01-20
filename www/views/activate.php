<?php

// TODO This is not a view! It's a script.. that can be inbedded into course view..

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canToggleCourseActive")) {
  header("Location: ?view=accessdenied");
  exit();
}

$course = $user->getCourse($cid);
$course->setActiveCourse();

$url = '?view=course&cid='.$cid;

header('Location:'.$url);
