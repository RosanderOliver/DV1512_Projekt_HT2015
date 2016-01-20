<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canAssignProjectToReviewer")) {
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
if (!empty($_POST) && Form::isValid("assignProjectsToReviewers")) {

  // Check each project
  foreach ($course->getProject() as $key => $value) {
    // If the project id is set in post add those users to project Reviewers
    if (isset($_POST[$value])) {
      $project = new Project($value);

      // Add Reviewers
      foreach ($_POST[$value] as $uid) {
        // Check if user is in course
        if ($course->userIsAssigned($uid)) {
          $project->addReviewer($uid);
        }
        // TODO else output error
      }
    }
    // TODO add else to remove users from project
  }

  echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {

  // Add all reviewers
  $reviewers = Array();
  foreach ($course->getReviewer() as $key => $value) {
    $reviewer = $course->getReviewer($value);
    $reviewers[$value] = $reviewer->real_name;
  }

  $form = new Form("assignProjectsToReviewers");
  $form->configure(array(
      "action" => "?view=assignprojects&cid=$cid"
  ));
  $form->addElement(new Element\HTML('<legend>Assign reviewers</legend>'));
  $form->addElement(new Element\Hidden("form", "assignReviewer"));

  // Print checkboxes here
  foreach ($course->getProject() as $key => $value) {
    $project = $course->getProject($value);

    $tmp = $reviewers;
    // Add feasible and selected
    foreach ($tmp as $key => $value) {
      // Add feasible reviewer
      if ( in_array($key, $project->feasible_reviewers) ) {
        $tmp[$key] .= '<b>*</b>';
      }
      if ( in_array($key, $project->reviewers) ) {
        $tmp[$key] .= '<script>$(\'input[value="'.$key.'"][name="'.$project->id.'[]"]\').attr(\'checked\',true);</script>';
      }
    }

    $form->addElement(new Element\Checkbox($project->subject.":", $project->id, $tmp));
  }

  $form->addElement(new Element\Button("Send"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
