<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canCreateCourse")) {
  header("Location: ?view=accessdenied");
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("createCourse")) {

    $course = Course::createCourse($_POST['name']);

    // Add the course to this user
    $user->addCourse($course->id);
    // Add current user as admin
    $course->addAdmin($_SESSION['user_id']);

    echo '<h3>Success!</h3><a href="?"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {

  $form = new Form("createCourse");
  $form->configure(array(
      "action" => "?view=createcourse"
  ));
  $form->addElement(new Element\HTML('<legend>Create new course</legend>'));
  $form->addElement(new Element\Hidden("form", "createCourse"));
  $form->addElement(new Element\Textbox("Name:", "name", array(
    //TODO The regex should use defined constants to more easily adapt
    // Regex still don't take special characters like åäö
    "validation" => new Validation\RegExp("/^[\d\p{L} ]{2,64}$/", "Error: The %element% field must contain only characters, numbers and whitespaces and be between 2 and 64 characters."),
    "required" => 1,
    "longDesc" => "Name of the course"
  )));
  $form->addElement(new Element\Button("Create"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
