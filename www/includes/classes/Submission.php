<?php

/**
* Handles project data and functions regarding handling data
* @author Jim Ahlstrand
* TODO Add comment function
*/
class Submission
{
  /**
  * @var object $dbh The database handler
  */
  private $dbh = null;
  /**
  * @var int $id The submission's database id
  */
  public $id = 0;
  /**
  * @var int $user id of the user
  */
  public $user = 0;
  /**
  * @var DateTime $date date of submission
  */
  public $date = null;
  /**
  * @var array $files array with file id
  */
  public $files = array();
  /**
  * @var array $reviews array with review id
  */
  private $reviews = array();
  /**
  * @var array $comments array with comment id
  */
  public $comments = array();
  /**
  * @var int $grade grade of the submission
  */
  public $grade = 0;
  /**
  * @var int $stage stage of the submission
  */
  public $stage = 0;

  /**
  * Constructor
  * @param  int   $id   id of the submission to load
  */
  public function __construct($id)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

    // Get the submission id
    $submission = intval($id);
    if ($submission <= 0) {
      throw new Exception("Invalid submission id");
    }

    $sth = $this->dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
    $sth->bindParam(':id', $submission, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    // If the submission does not exists
    if (!$result) throw new Exception("Could not find requested submission");

    $this->id = $result->id;
    $this->user = $result->user;
    $this->date = new DateTime($result->date);
    $this->files = unserialize($result->files);
    $this->reviews = unserialize($result->reviews);
    $this->comments = unserialize($result->comments);
    $this->grade = intval($result->grade);
    $this->stage = intval($result->stage);
  }

  /**
  * @author Jim Ahlstrand, Oliver Rosander
  * @param int $reviewID id of the review to add
  * @return null
  */
  public function addReview($reviewID)
  {
    // Check input
    if (intval($reviewID) < 0) {
      throw new Exception("Invalid input reviewID");
    } else {
      $reviewID = intval($reviewID);
    }


    // Search for user in reviews array
    if (array_key_exists($_SESSION['user_id'], $this->reviews)) {
      $this->reviews[$_SESSION['user_id']][] = $reviewID;
    } else {
      //Appned new user and reviewid
      $this->reviews[$_SESSION['user_id']] = array($reviewID);
    }

    $stringReviews = serialize($this->reviews);
    $sth = $this->dbh->prepare(SQL_UPDATE_SUBMISSION_REVIEWS_WHERE_ID);
    $sth->bindParam(':reviews', $stringReviews, PDO::PARAM_STR);
    $sth->bindParam(':id', $this->id, PDO::PARAM_INT);
    $sth->execute();

  }

  /**
  * @author Jim Ahlstrand, Oliver Rosander
  * @return bool true if user has reviewd
  */
  function userHasReviewed(){
    return array_key_exists($_SESSION['user_id'], $this->reviews);
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
  * @param int, $id, Id of the review to be fetched defaults to null
  * @return obj, stdClassObject
  * TODO return only submissions that the user own or has permission to view
  */
  public function getReview( $id = null )
  {
    // If id is null return a list of all submissions listed for the project
    if ($id === null)
      return $this->reviews;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0)
      throw new Exception("Invalid parameter");

    // Check so submission exists in the course
    if (!in_array($id, $this->reviews))
      throw new Exception("Invalid review request");

    return new Review($id);
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

      $sth = $this->dbh->prepare(SQL_UPDATE_SUBMISSION_COMMENTS_WHERE_ID);
      $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
      $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
      $sth->execute();

    } catch (Exception $e) {
      echo $e->getMessage();
    }
  }

  /**
  * @author Jim Ahlstrand
  * @param int $grade integer with the grade
  */
  public function setGrade($grade)
  {
    // Check input
    if (!key_exists($grade, $GLOBALS['grades'])) {
      throw new Exception("Invalid grade");
    }

    // Update the database
    $this->grade = $grade;

    $sth = $this->dbh->prepare(SQL_UPDATE_SUBMISSION_GRADE_WHERE_ID);
    $sth->bindParam(":grade", $this->grade, PDO::PARAM_INT);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }
}
