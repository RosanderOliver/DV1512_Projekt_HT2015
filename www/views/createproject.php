<?php

if (!defined('IN_EXM')) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canCreateProject")) {
  header("Location: ?view=accessdenied");
  exit();
}

// Get course id
$cid = getCID();

// Namespaces to use
use PFBC\Form;
use PFBC\Element;
use PFBC\Validation;


// If form is submitted and correct
if (!empty($_POST) && Form::isValid('createProject')) {

    // This functions is disabled until students get activated
    //$uid = findUser($_POST['student']);

    // Get current Course
    $course = $user->getCourse($cid);

    /*if( $uid == -1 ) {
      Form::setError('createProject', 'Error: Unable to find that user.');
      header("Location: ?view=createproject&cid=$cid");
    } else {
      Form::clearValues('createProject');
    }*/

    $subject = $_POST['subject'];
    $deadline = new DateTime($_POST['deadline'].' '.$_POST['deadlineTime']);
    $stage = intval($_POST['stage']);

    // Create Project
    $project = Project::createProject($subject, $deadline, $stage, $cid);

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
  $form->addElement(new Element\Date('Deadline:', 'deadline', array(
    'required' => 1,
    'longDesc' => 'Select a deadline for this project'
  )));
  $form->addElement(new Element\Time('Time:', 'deadlineTime', array(
    'required' => 1,
    'longDesc' => 'Select a time for the deadline'
  )));
  $form->addElement(new Element\Button('Create'));
  $form->addElement(new Element\Button('Cancel', 'button', array(
  	'onclick' => 'history.go(-1);'
  )));

  $form->render();
}
