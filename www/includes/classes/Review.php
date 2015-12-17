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
  * @var int $user id of the user
  */
  public $user = 0;
  /**
  * @var DateTime $date date of review
  */
  public $date = null;
  /**
  * @var array $comments array with comment id
  */
  public $comments = array();
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
    try {
      // Generate a database connection, using the PDO connector
      $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $e) {
      // If shit hits the fan
      throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
    }

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
}
