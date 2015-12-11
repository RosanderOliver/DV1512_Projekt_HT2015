<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Get Submission id
$pid;
if (isset($_GET['sid']) && intval($_GET['sid']) > 0) {
  $pid = intval($_GET['sid']);
} else {
  exit("Invalid submission!");
}

$submission = new Submission($sid);

foreach ($submission->reviews as $key => $value) {

  // Get review
  $sth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID);
  $sth->bindParam(':rid', $value, PDO::PARAM_INT);
  $sth->execute();
  $review = $sth->fetch(PDO::FETCH_OBJ);
  $data = unserialize($review->data);

  $user = new User( $data->user );

  echo '<div class="review_box">';
  if (get_class($data) == "TE"){
    echo '<br><a target="_blank" href="?view=thesis&sid='.$lastSubmissionIndex.'&uid='.$data->user.'"></a>';
  } elseif (get_class($data) == "PP") {
    echo '<br><a target="_blank" href="?view=pp&sid='.$lastSubmissionIndex.'&uid='.$data->user.'">Link to REVIEWS NAMES REVIEW FORMULARY</a>';
  }
}
