<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get Submission id
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

  // If comment form was submitted
  $commentSubmitId = 'comment'.$review->id;
  if ($_POST[$commentSubmitId]) {
    //$review->addComment($_POST[$commentSubmitId]); //TODO fix this function
  }

  // Get the user associated with the review and print some data
  $user = new User( $review->user );

  echo '<div class="review_box">';

  // Name of reviewer
  echo '<h4 style="margin-bottom:0em;">'.$user->real_name.'</h4>';
  echo '<p>';
  // Link to review
  if (get_class($review->data) == "TE"){
    echo '<a href="?view=reviewthesis&sid='.$submission->id.'&uid='.$review->user.'">View Review</a><br/>';
  } elseif (get_class($review->data) == "PP") {
    echo '<a href="?view=reviewplan&sid='.$submission->id.'&uid='.$review->user.'">View review</a><br/>';
  }

  // Date
  echo 'Date: '.$review->date->format("Y-m-d H:i:s").'<br/>';

  // Feedback
  echo 'Feedback: '.$review->data->feedback.'<br/>';

  // Comments
  foreach ($review->getComments() as $key => $value) {
    echo '<br/>Comment: '.$value->data;
  }

  // Print form for submitting Comments
  print('
  <form method="post" name="commentForm" action="?view=projectreviews&sid='.$sid.'">
    <textarea name="comment'.$review->id.'" id="comment"></textarea><br/>
    <input type="submit" name="submitComment" value="Comment">
  </form>
  ');

  echo '</p>';
  echo '</div>';
}
