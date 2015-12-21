<?php

if (!defined('IN_EXM')) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get course id
if (isset($_GET['cid']) && intval($_GET['cid']) > 0) {
  $id = intval($_GET['cid']);
} else {
  exit('Invalid id!');
}

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;

echo '<div class="row">';
echo '<div class="col-md-12">';

// If form is submitted and correct
if (!empty($_POST) && Form::isValid('createProject', false)) {

    $uid = findUser($_POST['student'], $dbh);

    // Get current Course
    $course = $user->getCourse($id);

    if( $uid == -1 ) {
      Form::setError('createProject', 'Error: Unable to find that user.');
      header("Location: ?view=createproject&cid=$id");
    } else {
      Form::clearValues('createProject');
    }

    // TODO here we assume the examinator is the current user...
    $examinators = serialize(array(intval($_SESSION['user_id'])));

    $deadline = new DateTime($_POST['deadline']);
    $deadline = $deadline->format('Y-m-d H:i:s');
    $stage = intval($_POST['stage']);

    $sth = $dbh->prepare(SQL_INSERT_PROJECT);
    $sth->bindParam(':subject', $_POST['subject'], PDO::PARAM_STR);
    $sth->bindParam(':stage', $stage, PDO::PARAM_INT);
    $sth->bindParam(':examinators', $examinators, PDO::PARAM_STR);
    $sth->bindParam(':deadline', $deadline, PDO::PARAM_STR);
    $sth->execute();

    // Add the project to the course
    $course->addProject($dbh->lastInsertId());

    // Add the student to the project
    $project = new Project($dbh->lastInsertId());
    $project->addStudent($uid);

    echo '<h3>Success!</h3><a href="?view=course&cid='.$id.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {

  $form = new Form('createProject');
  $form->configure(array(
      'action' => "?view=createproject&cid=$id"
  ));
  $form->addElement(new Element\HTML('<legend>Create new project</legend>'));
  $form->addElement(new Element\Hidden('form', 'createProject'));
  $form->addElement(new Element\Textbox('Subject:', 'subject', array(
    //TODO The regex should use defined constants to more easily adapt
    // Regex still don't take special characters like åäö
    'validation' => new Validation\RegExp('/^[\p{L} ]{2,64}$/', 'Error: The %element% field must contain only characters and whitespaces and be between 2 and 64 characters.'),
    'required' => 1
  )));
  $form->addElement(new Element\Select('Stage:', 'stage', $stages, array(
    //TODO The regex should use defined constants to more easily adapt
    'validation' => new Validation\RegExp('/^[1-5]{1}$/', 'Error: The %element% field is not valid.'),
    'required' => 1,
    'longDesc' => 'Starting stage of the project'
  )));
  $form->addElement(new Element\Textbox('Student:', 'student', array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    'validation' => new Validation\RegExp('/^[a-z\d]{2,64}$/', 'Error: The %element% field must contain a username.'),
    'required' => 1,
    'longDesc' => 'Assign a student to this project with it\'s acronym'
  )));
  $form->addElement(new Element\DateTimeLocal('Deadline:', 'deadline', array(
    'validation' => new Validation\RegExp('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', 'Error: The %element% field must contain a date.'),
    'required' => 1,
    'longDesc' => 'Select a deadline for this project (Y-m-dTH:i)'
  )));
  $form->addElement(new Element\Button('Create'));
  $form->addElement(new Element\Button('Cancel', 'button', array(
  	'onclick' => 'history.go(-1);'
  )));

  $form->render();
}

echo '</div>';
echo '</div>';
