<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);


  echo '<h2>Archived Courses</h2>';
  echo '<ul>';

  foreach ($user->getCourse() as $key => $value) {
    $course = $user->getCourse($value);
    if (!$course->active) {
      echo '<li>';
      echo '<a href="?view=course&cid='.$course->id.'">'.$course->name."</a>";
      echo '</li>';
    }
  }

  echo '</ul>';
