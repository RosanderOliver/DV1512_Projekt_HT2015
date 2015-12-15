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

  // If comment form was submitted add the comment
  $commentSubmitId = 'comment'.$review->id;
  if (key_exists($commentSubmitId, $_POST)) {
    $review->addComment($_POST[$commentSubmitId]);
  }

  echo '<div class="review_box">';
  echo '<p>';

  // Link to review
  if (get_class($review->data) == "TE"){
    echo '<a class="bold" href="?view=reviewthesis&sid='.$submission->id.'&uid='.$review->user.'">';
  } elseif (get_class($review->data) == "PP") {
    echo '<a class="bold" href="?view=reviewplan&sid='.$submission->id.'&uid='.$review->user.'">';
  }

  // Is it your review or someone elses?
  if ($review->user == $_SESSION['user_id']) {
    echo '<h4 style="margin-bottom: 0em;">Your review</h4>';
  } else {
    echo '<h4 style="margin-bottom: 0em;">Read this review</h4>';
  }

  echo '</a><br/>';

  // Date
  echo 'Date: '.$review->date->format("Y-m-d H:i:s").'<br/>';

  // Feedback
  echo 'Feedback: '.$review->data->feedback.'<br/>';

  // Comments
  echo '<div class="comments"><p>Comments:</p>';
  $review->printComments();
  echo '</div>';

  // Print form for submitting Comments
  print('
  <form method="post" name="commentForm" action="?view=projectreviews&sid='.$sid.'">
    <textarea name="comment'.$review->id.'" id="comment"></textarea><br/>
    <input type="submit" name="submitComment" value="Comment">
  </form>
  ');

  echo '</p>';
  echo '</div>';
  echo '<hr/>';
}
