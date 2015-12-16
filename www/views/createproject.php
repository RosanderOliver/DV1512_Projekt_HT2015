<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if(Form::isValid("createProject")) {

    $sth = $dbh->prepare(SQL_INSERT_COURSE);
    $sth->bindParam(":name", $_POST["name"], PDO::PARAM_STR);
    $sth->execute();

    // Add the course to this user
    $user->addCourseID($dbh->lastInsertId());

    $course = new Course($dbh->lastInsertId());
    $course->addAdmin($_SESSION['user_id']);

    $form = new Form("success");
    $form->addElement(new Element\HTML('<legend>Success</legend>'));
    $form->addElement(new Element\Button("Done"));
    $form->render();
}
// Else print the form
else {

  $form = new Form("createProject");
  $form->configure(array(
      "action" => "?view=createproject"
  ));
  $form->addElement(new Element\HTML('<legend>Create new project</legend>'));
  $form->addElement(new Element\Hidden("form", "createProject"));
  $form->addElement(new Element\Textbox("Subject:", "subject", array(
    "required" => 1
  )));
  $form->addElement(new Element\Select("Stage:", "stage", $stages, array(
    "required" => 1,
    "longDesc" => "Starting stage of the project"
  )));
  $form->addElement(new Element\Button("Create"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
