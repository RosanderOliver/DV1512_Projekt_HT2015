<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canAssignReviewer")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("assignReviewer", false)) {

  $uid = findUser($_POST['username']);

  // Get current Course
  $course = $user->getCourse($cid);

  if( $uid == -1 ) {
    Form::setError('assignReviewer', 'Error: Unable to find that user.');
    header("Location: ?view=assignreviewer&cid=$cid");
    exit();
  } else {
    Form::clearValues('assignReviewer');
  }

  // Add user to examinators
  $course->addReviewer($uid);

  echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {
  $form = new Form("assignReviewer");
  $form->configure(array(
      "action" => "?view=assignreviewer&cid=$cid"
  ));
  $form->addElement(new Element\HTML('<legend>Assign new reviewer</legend>'));
  $form->addElement(new Element\Hidden("form", "assignReviewer"));
  $form->addElement(new Element\Textbox('Username:', 'username', array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    'validation' => new Validation\RegExp('/^[a-z\d]{2,64}$/', 'Error: The %element% field must contain a username.'),
    'required' => 1,
    'longDesc' => 'This user will be added as a reviewer to the course'
  )));
  $form->addElement(new Element\Button("Add user"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
