<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit();

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canSelectProjectsToReview")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get current Course
$course = $user->getCourse($cid);

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("selectProjectsToReview")) {

  // Add reviewer to all selected projects
  foreach ($_POST['projects'] as $key => $value) {
    try {
      $project = $course->getProject($value);
      $project->addFeasibleReviewer($GLOBALS['user']->id);
    } catch (Exception $e) {
      // Do nothing, quietly continue
    }
  }

  echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {

  // Add all projects
  $projects = Array();
  foreach ($course->getProject(null, false) as $key => $value) {
    $project = $course->getProject($value);
    $projects[$value] = $project->subject;
  }

  $form = new Form("selectProjectsToReview");
  $form->configure(array(
      "action" => "?view=selectprojects&cid=$cid"
  ));
  $form->addElement(new Element\HTML('<legend>Select projects</legend>'));
  $form->addElement(new Element\Hidden("form", "selectProjectsToReview"));
  $form->addElement(new Element\Checkbox("Projects I can review:", "projects", $projects));
  $form->addElement(new Element\Button("Send"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
