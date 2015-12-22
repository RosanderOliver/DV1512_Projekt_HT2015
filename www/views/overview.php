<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

  echo '<div class="row">';
  echo '<div class="col-md-3">';
  echo '<h2>Active Courses</h2>';
  echo '<ul>';
  foreach ($user->getCourse() as $key => $value) {
    $course = $user->getCourse($value);
    echo '<li>';
    echo '<a href="?view=course&cid='.$course->id.'">'.$course->name."</a>";
    echo '</li>';
  }
  echo '</ul>';

  echo '</div>';
  echo '<div class="col-md-6">';

  echo '<h2>Overview</h2>';
  print('
    <h3>Former BTH students among Swedens best developers.</h3>
    <p>Lorem ipsum dolor sit amet, esse molestie reformidans has id, has purto audire graecis ut.</p>
    <h3>Multicultural environment at BTH</h1>
    <p>Life on campus is multicultural as we attract students and staff from many countries in the world. In addition to the large number of nationalities</p>
    <h3>European Network Intelligent Conference 2015</h3>
    <p>The European Network Intelligent Conference, ENIC 2015 was recently held at BTH in collaboration with several international partner universities.</p>
    <br>
  ');

  echo '</div>';
  echo '<div class="md-col-3">';
  echo '<h2>Tasks</h2>';

  $list = array();
  if ($user->hasPrivilege("canCreateCourse")) {
    $list[] = array('Create new course', '?view=createcourse');
  }
  if ($user->hasPrivilege("canViewPermissions")) {
    $list[] = array('View permissions', '?view=permissions');
  }
  printULLink($list);

  echo '</div>';
  echo '</div>';
