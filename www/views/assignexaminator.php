<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
$cid = getCID();

// Test permissions
if (!$user->hasPrivilege("canAssignExaminator")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("assignExaminator", false)) {

  $uid = findUser($_POST['username']);

  // Get current Course
  $course = $user->getCourse($cid);

  if( $uid == -1 ) {
    Form::setError('assignExaminator', 'Error: Unable to find that user.');
    header("Location: ?view=assignexaminator&cid=$cid");
    exit();
  } else {
    Form::clearValues('assignExaminator');
  }

  // Add user to examinators
  $course->addExaminator($uid);

  echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {
  $form = new Form("assignExaminator");
  $form->configure(array(
      "action" => "?view=assignexaminator&cid=$cid"
  ));
  $form->addElement(new Element\HTML('<legend>Assign new examinator</legend>'));
  $form->addElement(new Element\Hidden("form", "assignExaminator"));
  $form->addElement(new Element\Textbox('Username:', 'username', array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    'validation' => new Validation\RegExp('/^[a-z\d]{2,64}$/', 'Error: The %element% field must contain a username.'),
    'required' => 1,
    'longDesc' => 'This user will be added as an examinator to the course'
  )));
  $form->addElement(new Element\Button("Add user"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
