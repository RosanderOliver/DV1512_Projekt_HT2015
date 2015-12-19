<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $id = intval($_GET['cid']);
} else {
  exit("Invalid id!");
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

// If form is submitted and correct
if (!empty($_POST) && Form::isValid("createProject", false)) {

    $uid = findUser($_POST['student'], $dbh);

    // Get current Course
    $course = $user->getCourse($id);

    if( $uid == -1 ) {
      Form::setError("createProject", "Error: Unable to find that user.");
      header("Location: ?view=createproject&cid=$id");
    } else {
      Form::clearValues("createProject");
    }

    // TODO here we assume the examinator is the current user...
    $examinators = serialize(array(intval($_SESSION['user_id'])));

    $sth = $dbh->prepare(SQL_INSERT_PROJECT);
    $sth->bindParam(":subject", $_POST["subject"], PDO::PARAM_STR);
    $sth->bindParam(":stage", intval($_POST["stage"]), PDO::PARAM_INT);
    $sth->bindParam(":examinators", $examinators, PDO::PARAM_INT);
    $sth->execute();

    // Add the project to the course
    $course->addProject($dbh->lastInsertId());

    // Add the student to the project
    $project = new Project($dbh->lastInsertId());
    $project->addStudent($uid);

    $form = new Form("success");
    $form->addElement(new Element\HTML('<legend>Success</legend>'));
    $form->addElement(new Element\Button("Done"));
    $form->render();
}
// Else print the form
else {

  $form = new Form("createProject");
  $form->configure(array(
      "action" => "?view=createproject&cid=$id"
  ));
  $form->addElement(new Element\HTML('<legend>Create new project</legend>'));
  $form->addElement(new Element\Hidden("form", "createProject"));
  $form->addElement(new Element\Textbox("Subject:", "subject", array(
    //TODO The regex should use defined constants to more easily adapt
    // Regex still don't take special characters like åäö
    "validation" => new Validation\RegExp("/^[\p{L} ]{2,64}$/", "Error: The %element% field must contain only characters and whitespaces and be between 2 and 64 characters."),
    "required" => 1
  )));
  $form->addElement(new Element\Select("Stage:", "stage", $stages, array(
    //TODO The regex should use defined constants to more easily adapt
    "validation" => new Validation\RegExp("/^[1-5]{1}$/", "Error: The %element% field is not valid."),
    "required" => 1,
    "longDesc" => "Starting stage of the project"
  )));
  $form->addElement(new Element\Textbox("Student:", "student", array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    "validation" => new Validation\RegExp("/^[\p{L}\d]{4,6}$/", "Error: The %element% field must contain an acronym on the form abcd99."),
    "required" => 1,
    "longDesc" => "Assign a student to this project with it's acronym"
  )));
  $form->addElement(new Element\Button("Create"));
  $form->addElement(new Element\Button("Cancel", "button", array(
  	"onclick" => "history.go(-1);"
  )));

  $form->render();
}
