<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$id;
if (isset($_GET['id']) && intval($_GET['id']) > 0) {
  $id = intval($_GET['id']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($id);


if($course->select_projects == 0){
  echo "<h2>Projects to review</h2></br>";
  echo "<ul>";
  foreach($course->getProject() as $key => $value){
    $project = $course->getProject($value);
    for($i = 0; $i < sizeof($project->reviewers); $i++){
      if($project->reviewers[$i] == $user->id){
        echo '<li><a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a></li>';
      }
    }

  }
  echo "</ul>";

}else if($course->select_projects == 1) {
  // List projects
  echo '<h2>Select projects</h2>';

  echo '<form action="index.php?view=selectedprojects" method="POST">';
  echo '<ul>';
  foreach ($course->getProject() as $key => $value) {
    $project = $course->getProject($value);
    echo '<li>';
    echo '<a href="?view=projectoverview&pid='.$project->id.'&cid='.$course->id.'">'.$project->subject.'</a> <input type="checkbox" name="ticked[]" value="'.$value.'">';
    echo '<input type="hidden" name="id[]" value="'.$project->id.'">';
    echo '</li>';
  }
  echo '</ul>';
  echo '<input type="submit" name="submit" value="Submit">';
  echo '</form>';

}
