<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get project id
// TODO: Check that the user can access this project
$id;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $id = intval($_GET['id']);
  $id--; // Correcting for array alignment
} else {
  exit("Invalid id!");
}

// Check so the id is in range
if ($id > count($user->courses)) {
  exit("Invalid id range!");
}

echo '<h2>Your projects</h2>';

echo '<ul>';
foreach ($user->courses[$id]->projects as $key => $value) {
  echo '<li>';
  echo $value->subject;
  echo '</li>';
}
echo '</ul>';
