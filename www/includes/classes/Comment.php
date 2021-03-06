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
  * @param int $id id of the comment to load
  */
  public function __construct($id = null)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

    // Get the comment id
    $comment = intval($id);
    if ($comment <= 0) {
      throw new Exception("Invalid comment id");
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

  /**
  * Insert data in database with currentdate and time
  * @author Jim Ahlstrand
  * @return int Id of inserted row
  */
  private function insertComment()
  {
    // Prepare variables
    $date = $this->date->format("Y-m-d H:i:s");
    $subcomments = serialize($this->subcomments);

    $sth = $this->dbh->prepare(SQL_INSERT_COMMENT);
    $sth->bindParam(":user", $this->user, PDO::PARAM_INT);
    $sth->bindParam(':date', $date, PDO::PARAM_STR);
    $sth->bindParam(":data", $this->data, PDO::PARAM_STR);
    $sth->bindParam(":subcomments", $subcomments, PDO::PARAM_STR);
    $sth->execute();

    return $this->dbh->lastInsertId();
  }

  /**
  * @author Jim Ahlstrand
  * @return array id's of subcomments
  */
  function getSubComments() {
    return $this->subcomments;
  }

  /**
  * Insert data in database with currentdate and time
  * @author Jim Ahlstrand
  * @param string $comment content of the comment
  * @return Comment object with the created comment
  */
  public static function createComment($comment)
  {
    if (!empty($comment)) {
      // Check data
      $data = htmlspecialchars(trim($comment));
      if (empty($data) || !isset($data)) {
        throw new Exception("No comment data given");
      }
      if (strlen($data) > MAX_COMMENT_LENGTH) {
        throw new Exception("Comment data too long");
      }

      // Set date to current date
      $date = date("Y-m-d H:i:s");
      // Set user to current user
      $user = $_SESSION['user_id'];
      // Set subcomments to empty
      $subcomments = serialize(array());

      $sth = $GLOBALS['dbh']->prepare(SQL_INSERT_COMMENT);
      $sth->bindParam(":user", $user, PDO::PARAM_INT);
      $sth->bindParam(':date', $date, PDO::PARAM_STR);
      $sth->bindParam(":data", $data, PDO::PARAM_STR);
      $sth->bindParam(":subcomments", $subcomments, PDO::PARAM_STR);
      $sth->execute();

      return new Comment($GLOBALS['dbh']->lastInsertId());
    }
    // Invalid request
    else {
      throw new Exception("Invalid comment");
    }
  }

}
