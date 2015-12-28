<?php

  if (!defined("IN_EXM")) exit(1);
  if ($login->isUserLoggedIn() === false) exit(1);

  if (isset($_GET['sid'])) {
    $sid = intval($_GET['sid']);
  } else {
    exit("Invalid submission");
  }

  $submission = new Submission($sid);

  if(isset($_POST['submit'])){

    //TODO This should be stdClass and generalized
    $data = new TE();

    $data->student1 = input_length(test_input($_POST["student1"]));
    $data->s1email = input_length(test_input($_POST["s1email"]));
    $data->pnr1 = input_length(test_input($_POST["pnr1"]));

    $data->student2 = input_length(test_input($_POST["student2"]));
    $data->s2email = input_length(test_input($_POST["s2email"]));
    $data->pnr2 = input_length(test_input($_POST["pnr2"]));

    $data->title = input_length(test_input($_POST["title"]));
    $data->supervisor = input_length(test_input($_POST["supervisor"]));
    $data->thesistype = input_length(test_input($_POST["thesistype"]));

    $data->process1 = length_one(test_input(test_num($_POST["process1"])));
    $data->process2 = length_one(test_input(test_num($_POST["process2"])));
    $data->process3 = length_one(test_input(test_num($_POST["process3"])));
    $data->process4 = length_one(test_input(test_num($_POST["process4"])));

    $data->s1 = length_three(test_input(test_num($_POST["s1"])));

    $data->content1 = length_one(test_input(test_num($_POST["content1"])));
    $data->content2 = length_one(test_input(test_num($_POST["content2"])));
    $data->content3 = length_one(test_input(test_num($_POST["content3"])));

    $data->s2 = length_three(test_input(test_num($_POST["s2"])));

    $data->contribution1 = length_one(test_input(test_num($_POST["contribution1"])));
    $data->contribution2 = length_one(test_input(test_num($_POST["contribution2"])));
    $data->contribution3 = length_one(test_input(test_num($_POST["contribution3"])));

    $data->s3 = length_three(test_input(test_num($_POST["s3"])));

    $data->presentation1 = length_one(test_input(test_num($_POST["presentation1"])));
    $data->presentation2 = length_one(test_input(test_num($_POST["presentation2"])));
    $data->presentation3 = length_one(test_input(test_num($_POST["presentation3"])));
    $data->presentation4 = length_one(test_input(test_num($_POST["presentation4"])));
    $data->presentation5 = length_one(test_input(test_num($_POST["presentation5"])));

    $data->s4 = length_three(test_input(test_num($_POST["s4"])));
    $data->s5 = length_three(test_input(test_num($_POST["s5"])));
    $data->s6 = length_one(test_input(test_grade($_POST["s6"])));

    $data->impression = input_length(test_input($_POST["impression"]));
    $data->rname = input_length(test_input($_POST["rname"]));
    $data->date = length_date(test_input($_POST["date"]));
    $data->feedback = input_length(test_input($_POST["feedback"]));

    // Create the review
    $review = Review::createReview($data);
    // Add it to the submission
    $submission->addReview($review->id);

    echo '<h3>Success!</h3><a href="?"><button class="btn btn-success">Go back</button></a>';
}
// Else print the fprm
else{

  $data;
  $latestID = $submission->getLatestReview($user->id);
  // If user already has a review
  if ($latestID > -1) {
    $review = new Review($latestID);
    $data = $review->data;
  }

  include('includes/content/dp_thesis-eval_supervisor.php');
}
