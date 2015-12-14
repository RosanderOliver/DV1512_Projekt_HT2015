<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get Submission id
$sid;
if (isset($_GET['sid']) && intval($_GET['sid']) > 0) {
  $sid = intval($_GET['sid']);
} else {
  exit("Invalid submission!");
}

$submission = new Submission($sid);

foreach ($submission->reviews as $key => $value) {

  // Get the last id in the array
  $id = intval($value[count($value) - 1]);

  // Get review
  $review = new Review($id);

  // Get the user associated with the review and print some data
  $user = new User( intval($review->user) );

  echo '<div class="review_box">';

  // Name of reviewer, also link to review
  if (get_class($review->data) == "TE"){
    echo '<br><a target="_blank" href="?view=thesis&sid='.$lastSubmissionIndex.'&uid='.$review->user.'"><h4>'.$user->given_name.'</h4></a>';
  } elseif (get_class($review->data) == "PP") {
    echo '<br><a target="_blank" href="?view=pp&sid='.$lastSubmissionIndex.'&uid='.$review->user.'"><h4>'.$user->given_name.'</h4></a>';
  }

  // Date
  $date = new DateTime($review->data->date);
  echo 'Date: '.$date->format("Y-m-d H:i:s").'</br>';

  // Feedback
  echo 'Feedback: '.$review->data->feedback.'</br>';

  // Comments
  foreach ($review->getComments() as $key => $value) {
    echo '<br>Comment: '.$value->data;
  }

  echo '</div>';
}
