<?php

// TODO Use pid and cid to autofill relevant info and permissions support

  if (!defined("IN_EXM")) exit(1);
  if ($login->isUserLoggedIn() === false) exit(1);

  // Get sid
  if (isset($_GET['sid']) && intval($_GET['sid']) > 0) {
    $sid = intval($_GET['sid']);
  } else {
    exit("Invalid submission");
  }

  // Get uid
  if (isset($_GET['uid']) && intval($_GET['uid']) > 0) {
    $uid = intval($_GET['uid']);
  }

  // Test permissions
  // TODO Check if user can view this review by checking permission for view all reviews or user owns this review
  // TODO Check if user can write to this review, or if it's view only
  /*if (!$user->hasPrivilege("canReview")) {
    header("Location: ?view=accessdenied");
    exit();
  }*/

  $submission = new Submission($sid);

  if (isset($_POST['submit'])) {
   $form = new PP();

   $form->student1  = test_input($_POST["student1"]);
   $form->s1email   = test_input($_POST["s1email"]);
   $form->pnr1      = test_input($_POST["pnr1"]);

   $form->student2  = test_input($_POST["student2"]);
   $form->s2email   = test_input($_POST["s2email"]);
   $form->pnr2      = test_input($_POST["pnr2"]);

   $form->title     = test_input($_POST["title"]);
   $form->course    = test_input($_POST["course"]);
   $form->supervisor = test_input($_POST["supervisor"]);
   $form->term      = test_input($_POST["term"]);
   $form->type      = test_input($_POST["type"]);

   $form->process1 = test_input(test_num($_POST["process1"]));
   $form->processcomment1 = test_input($_POST["processcomment1"]);
   $form->process2 = test_input(test_num($_POST["process2"]));
   $form->processcomment2 = test_input($_POST["processcomment2"]);
   $form->process3 = test_input(test_num($_POST["process3"]));
   $form->processcomment3 = test_input($_POST["processcomment3"]);

   $form->s1 = test_num($_POST["s1"]);

   $form->content1 = test_input(test_num($_POST["content1"]));
   $form->contentcomment1 = test_input($_POST["contentcomment1"]);
   $form->content2 = test_input(test_num($_POST["content2"]));
   $form->contentcomment2 = test_input($_POST["contentcomment2"]);
   $form->content3 = test_input(test_num($_POST["content3"]));
   $form->contentcomment3 = test_input($_POST["contentcomment3"]);
   $form->content4 = test_input(test_num($_POST["content4"]));
   $form->contentcomment4 = test_input($_POST["contentcomment4"]);

   $form->s2 = test_input(test_num($_POST["s2"]));

   $form->presentation1 = test_input(test_num($_POST["presentation1"]));
   $form->presentationcomment1 = test_input($_POST["presentationcomment1"]);
   $form->presentation2 = test_input(test_num($_POST["presentation2"]));
   $form->presentationcomment2 = test_input($_POST["presentationcomment2"]);
   $form->presentation3 = test_input(test_num($_POST["presentation3"]));
   $form->presentationcomment3 = test_input($_POST["presentationcomment3"]);
   $form->presentation4 = test_input(test_num($_POST["presentation4"]));
   $form->presentationcomment4 = test_input($_POST["presentationcomment4"]);
   $form->presentation5 = test_input(test_num($_POST["presentation5"]));
   $form->presentationcomment5 = test_input($_POST["presentationcomment5"]);

   $form->s3 = test_num(test_input(test_num($_POST["s3"])));
   $form->s4 = test_num(test_input(test_num($_POST["s4"])));
   $form->feedback = test_input($_POST["feedback"]);

   // Create the review
   $review = Review::createReview($form);
   // Add it to the submission
   $submission->addReview($review->id);

   echo '<h3>Success!</h3><a href="?"><button class="btn btn-success">Go back</button></a>';

}
// If no form was submitted print it
else {

  $data;
  if(isset($uid)) {
    $latestID = $submission->getLatestReview($uid);
  }
  else {
    $latestID = $submission->getLatestReview($user->id);
  }
  // If user already has a review
  if ($latestID > -1) {
    $review = new Review($latestID);
    $data = $review->data;
  }


  include('includes/content/dp_pp-eval-supervisor.php');
}
