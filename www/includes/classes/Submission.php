<?php

/**
* Handles project data and functions regarding handling data
* @author Jim Ahlstrand
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
  public $reviews = array();
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
  * @param  obj   $dbh  database handle
  */
  public function __construct($id, $dbh = null)
  {
    // Setup database handle
    try {
      // Generate a database connection, using the PDO connector
      $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $e) {
      // If shit hits the fan
      throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
    }

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

    $found = false;
    foreach ($this->reviews as $key => $value) {
      if ($key === $_SESSION['user_id']) {
        $value[] = $reviewID;
        $found = true;
      }
    }
    if ($found == false) {
      //Appned new user and reviewid
      $this->reviews[$_SESSION['user_id']] = array($reviewID);
    }
  }

  /**
  * @author Jim Ahlstrand, Oliver Rosander
  * @return null
  */
  function userHasReviewed(){
    foreach ($this->reviews as $key => $value) {
      // Get review
      $sth = $this->dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID);
      $sth->bindParam(':rid', $value, PDO::PARAM_INT);
      $sth->execute();
      $review = $sth->fetch(PDO::FETCH_OBJ);
      // Check if it belongs to the user
      if ($review->user === $_SESSION['user_id']) {
        return true;
      }
    }
    return false;
  }
}
