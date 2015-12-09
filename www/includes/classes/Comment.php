<?php

/**
* Handles project data and functions regarding handling data
* @author Jim Ahlstrand
* TODO Error checking when inserting comment
*/
class Comment
{
  /**
  * @var object $dbh The database handler
  */
  private $dbh = null;
  /**
  * @var int $id The course's database id
  */
  public $id = null;
  /**
  * @var string $user user who wrote the comment
  */
  public $user = "";
  /**
  * @var DateTime $date time of submission
  */
  public $date = null;
  /**
  * @var string $data content of comment
  */
  public $data = "";
  /**
  * @var array $subcomments array with id of the subcomments related to the comment
  */
  private $subcomments = Array();

  /**
  * Constructor
  * @param  int    $id    id of the comment to load
  * @param  string $data  data to be stored
  */
  public function __construct($id = null, $data = null)
  {
    // Setup database handle
    try {
      // Generate a database connection, using the PDO connector
      $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $e) {
      // If shit hits the fan
      throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
    }

    // Get comment
    if ($id != null) {

      // Get the comment id
      $comment = intval($id);
      if ($comment <= 0) {
        throw new Exception("Invalid course id");
      }

      $sth = $this->dbh->prepare(SQL_SELECT_COMMENT_WHERE_ID);
      $sth->bindParam(':id', $comment, PDO::PARAM_INT);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_OBJ);

      // If the project does not exists
      if (!$result) throw new Exception("Could not find requested comment");

      $this->id = $result->id;
      $this->user = $result->user;
      $this->date = new DateTime($result->date);
      $this->data = $result->data;
      $this->subcomments = unserialize($result->subcomments);

    }
    // Set Comment
    else if ($data != null) {
      // Check data
      $data = htmlspecialchars(trim($data));
      if (empty($data) || !isset($data)) {
        throw new Exception("No comment data given");
      }
      if (strlen($data) > MAX_COMMENT_LENGTH) {
        throw new Exception("Comment data too long");
      }

      // Set date to current date
      $this->date = new DateTime();

      // Set user to current user
      $this->user = $_SESSION['user_id'];

      // Set data
      $this->data = $data;

      // Set subcomments to empty
      $this->subcomments = Array();

      // Insert comment and save the id
      $this->id = $this->insertComment();
    }
    // Invalid request
    else {
      throw new Exception("Invalid construct");
    }
  }

  /**
  * Insert data in database with currentdate and time
  * @author Jim Ahlstrand
  * @return int Id of inserted row
  */
  private function insertComment() {
    // Prepare variables
    $date = $this->date->format("Y-m-d H:i:s");
    $subcomments = serialize($this->subcomments);

    $ssth = $dbh->prepare(SQL_INSERT_COMMENT);
    $ssth->bindParam(":user", $this->user, PDO::PARAM_INT);
    $ssth->bindParam(':date', $date, PDO::PARAM_STR);
    $ssth->bindParam(":data", $this->data, PDO::PARAM_STR);
    $ssth->bindParam(":subcomments", $subcomments, PDO::PARAM_STR);
    $ssth->execute();

    return $dbh->lastInsertId();
  }

}
