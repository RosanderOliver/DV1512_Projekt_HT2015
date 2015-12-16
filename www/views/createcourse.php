<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if(Form::isValid("createCourse")) {

    $sth = $dbh->prepare(SQL_INSERT_COURSE);
    $sth->bindParam(":name", $_POST["name"], PDO::PARAM_STR);
    $sth->execute();

    // Add the course to this user
    $user->addCourseID($dbh->lastInsertId());

    $form = new Form("success");
    $form->addElement(new Element\HTML('<legend>Success</legend>'));
    $form->addElement(new Element\Button("Done"));
    $form->render();
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
    "required" => 1,
    "longDesc" => "Name of the course"
  )));
  $form->addElement(new Element\Button("Create"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
