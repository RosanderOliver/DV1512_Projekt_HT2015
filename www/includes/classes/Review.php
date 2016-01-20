<?php

/**
* Handles review data and functions regarding handling data
* @author Jim Ahlstrand
*/
class Review
{
  /**
  * @var object $dbh The database handler
  */
  private $dbh = null;
  /**
  * @var int $id The review's database id
  */
  public $id = 0;
  /**
  * @var int $user id of the user submitting the review
  */
  public $user = 0;
  /**
  * @var DateTime $date date of review
  */
  public $date = null;
  /**
  * @var array $comments array with comment id
  */
  private $comments = array();
  /**
  * @var PP|TE $data review data object
  */
  public $data = null;

  /**
  * Constructor
  * @param  int   $id   id of the review to load
  */
  public function __construct($id)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

    // Get the review id
    $review = intval($id);
    if ($review <= 0) {
      throw new Exception("Invalid submission id");
    }

    $sth = $this->dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID);
    $sth->bindParam(':id', $review, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    // If the submission does not exists
    if (!$result) throw new Exception("Could not find requested review");

    $this->id = $result->id;
    $this->user = $result->user;
    $this->date = new DateTime($result->date);
    $this->comments = unserialize($result->comments);
    $this->data = unserialize($result->data);
  }

  /**
  * @author Jim Ahlstrand
  * @return array array of comments classes
  */
  function getComments() {
    $comments = array();
    foreach ($this->comments as $key => $value) {
      $comments[] = new Comment($value);
    }
    return $comments;
  }

  /**
  * @author Jim Ahlstrand
  * @param string $comment content of comment to be stored
  * @return void
  */
  function addComment($comment) {
    try {
      // Create the comment
      $comment = Comment::createComment($comment);

      // Update the database
      $this->comments[] = intval($comment->id);
      $comments = serialize($this->comments); // TODO Check so this actually fits in database

      $sth = $this->dbh->prepare(SQL_UPDATE_REVIEW_COMMENTS_WHERE_ID);
      $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
      $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
      $sth->execute();

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  /**
  * Recursively prints comments tree
  * @author Jim Ahlstrand
  * @param array $comments array with id of comments
  * @return void
  */
  function printComments($comments = null, $depth = 1) {
    // If we are at maximum comments depth or subcomments are empty
    if ($depth > MAX_COMMENT_DEPTH || $comments === array())
      return;

    // If comments array is null get the current array associated with this review
    if ($comments === null) {
      $comments = $this->getComments();
    }
    // Else construct the array
    else {
      $tmp = $comments;
      $comments = array();
      foreach ($tmp as $key => $value) {
        $comments[] = new Comment($value);
      }
    }

    // Loop through all comments
    foreach ($comments as $key => $comment) {

      $author = new User($comment->user);

      // main comment
      echo '<div class="well well-sm">
        <p class="content">'.$comment->data.'</p>
        <p class="author">'.$author->real_name.' - '.$comment->date->format('Y-m-d H:i:s').'</p>';

      // subcomments
      $this->printComments($comment->getSubComments(), $depth + 1);

      echo '</div>';
    }
  }

  /**
  * Creates a review and saves it in the DATABASE
  * @author Jim Ahlstrand
  * @param PP|TE $data object with data to serialize
  * @return Review an object with the created review
  */
  public static function createReview($data)
  {
    // Get the current user
    $user = $_SESSION['user_id'];
    // Get the current date
    $date = date("Y-m-d H:i:s");
    // Serialize the data
    //TODO Check so it's not too long
    $data = serialize($data);

    // Add it to the database
    $sth = $GLOBALS['dbh']->prepare(SQL_INSERT_REVIEW);
    $sth->bindParam(':user', $user, PDO::PARAM_INT);
    $sth->bindParam(':date', $date, PDO::PARAM_STR);
    $sth->bindParam(':data', $data, PDO::PARAM_STR);
    $sth->execute();

    // Return the newly created review
    return new Review($GLOBALS['dbh']->lastInsertId());
  }
}
