<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Get current Course
$course = $user->getCourse($cid);

// TODO Check if user can access this course

echo '<div class="row">';

// List projects
echo '<div class="col-md-8">';

echo '<h2>Your projects in '.$course->name.'</h2>';

$list = array();

  foreach ($course->getProject() as $key => $value) {
    $project = $course->getProject($value);
    if(in_array($user->id, $project->examinators)){ // TODO use permissions instead..
      $list[] = array($project->subject, '?view=projectoverview&pid='.$project->id.'&cid='.$cid);
    }else if(in_array($user->id,$project->reviewers)){
      $list[] = array($project->subject, '?view=projectoverview&pid='.$project->id.'&cid='.$cid);
    }
  }

printULLink($list);
echo '</div>';


// List tasks
echo '<div class="col-md-3">';
echo '<h2>Tasks</h2>';

$list = array();
if ($user->hasPrivilege("canCreateProject")) {
  $list[] = array('Create new project', '?view=createproject&cid='.$cid);
}
if ($user->hasPrivilege("canAddUserToCourse")) {
  $list[] = array('Add user', '?view=addusertocourse&cid='.$cid);
}
if ($user->hasPrivilege("canAssignCourseAdmin")) {
  $list[] = array('Assign admin', '?view=assigncourseadmin&cid='.$cid);
}
if ($user->hasPrivilege("canAssignReviewers") && $course->select_project == 0) {
  $list[] = array('Assign reviewers', '?view=assignreviewers&cid='.$cid);
}
if ($user->hasPrivilege("canSelectProjectsToReview")) {
  $list[] = array('Select projects to review', '?view=selectprojects&cid='.$cid);
}
// TODO Create seperate permission for this do not use an existing one!
if($user->hasPrivilege("canViewAllProjects")){ //admin, examinator
  if($course->select_project == 0){
   $list[] = array('Let reviewers selects projects','?view=openclose&cid='.$cid);
  }
  else{
   $list[] = array('Do not let reviewers select projects','?view=openclose&cid='.$cid);
  }
  if($course->active == 0){
   $list[] = array('Reactivate course','?view=activate&cid='.$cid);
  }
  else{
   $list[] = array('Inactivate course','?view=activate&cid='.$cid);
  }
}

printULLink($list);

echo '</div>';
//echo '</div>';
