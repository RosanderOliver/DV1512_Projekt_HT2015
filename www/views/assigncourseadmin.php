<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canAssignCourseAdmin")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $cid = intval($_GET['cid']);
} else {
  exit('Invalid id!');
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("assignCourseAdmin", false)) {

  $uid = findUser($_POST['username']);

  // Get current Course
  $course = $user->getCourse($cid);

  if( $uid == -1 ) {
    Form::setError('assignCourseAdmin', 'Error: Unable to find that user.');
    header("Location: ?view=assigncourseadmin&cid=$cid");
  } else {
    Form::clearValues('assignCourseAdmin');
  }

  // Add user to admins
  $course->addAdmin($uid);

  echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {
  $form = new Form("assignCourseAdmin");
  $form->configure(array(
      "action" => "?view=assigncourseadmin&cid=$cid"
  ));
  $form->addElement(new Element\HTML('<legend>Assign new courseadministrator</legend>'));
  $form->addElement(new Element\Hidden("form", "assignCourseAdmin"));
  $form->addElement(new Element\Textbox('Username:', 'username', array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    'validation' => new Validation\RegExp('/^[a-z\d]{2,64}$/', 'Error: The %element% field must contain a username.'),
    'required' => 1,
    'longDesc' => 'This user will be added as a course admin to the course'
  )));
  $form->addElement(new Element\Button("Add user"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
