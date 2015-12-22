<?php

if (!defined('IN_EXM')) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

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
if (!empty($_POST) && Form::isValid('createProject', false)) {

    // This functions is disabled until students get activated
    //$uid = findUser($_POST['student']);
    $uid = 0;

    // Get current Course
    $course = $user->getCourse($cid);

    if( $uid == -1 ) {
      Form::setError('createProject', 'Error: Unable to find that user.');
      header("Location: ?view=createproject&cid=$cid");
    } else {
      Form::clearValues('createProject');
    }

    // TODO here we assume the examinator is the current user...
    $examinators = array(intval($_SESSION['user_id']));
    $subject = $_POST['subject'];
    $deadline = new DateTime($_POST['deadline']);
    $stage = intval($_POST['stage']);

    // Create Project
    $project = Project::createProject($subject, $examinators, $deadline, $stage);

    // Add the project to the course
    $course->addProject($project->id);
    // Add the student to the project
    //$project->addStudent($uid);
    // Add a submission to the Project
    $project->createSubmission();

    echo '<h3>Success!</h3><a href="?view=course&cid='.$cid.'"><button class="btn btn-success">Go back</button></a>';
}
// Else print the form
else {

  $form = new Form('createProject');
  $form->configure(array(
      'action' => "?view=createproject&cid=$cid"
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
/*  $form->addElement(new Element\Textbox('Student:', 'student', array(
    //TODO The regex should use defined constants to more easily adapt
    //TODO a better regex should be implemented depending on acronym
    'validation' => new Validation\RegExp('/^[a-z\d]{2,64}$/', 'Error: The %element% field must contain a username.'),
    'required' => 1,
    'longDesc' => 'Assign a student to this project with it\'s acronym'
  )));*/
  $form->addElement(new Element\DateTimeLocal('Deadline:', 'deadline', array(
    'validation' => new Validation\RegExp('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', 'Error: The %element% field must contain a date.'),
    'required' => 1,
    'longDesc' => 'Select a deadline for this project'
  )));
  $form->addElement(new Element\Button('Create'));
  $form->addElement(new Element\Button('Cancel', 'button', array(
  	'onclick' => 'history.go(-1);'
  )));

  $form->render();
}
