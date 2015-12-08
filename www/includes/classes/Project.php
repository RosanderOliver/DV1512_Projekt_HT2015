<?php

/**
* Handles project data and functions regarding handling data
* @author Jim Ahlstrand
*/
class Project
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
  * @var string $subject subject of the project
  */
  public $subject = "";
  /**
  * @var int $stage stage of the project
  */
  public $stage = null;
  /**
  * @var int $grade grading of the project
  */
  public $grade = null;
  /**
  * @var array $submissions array with id of the submissions related to the project
  */
  public $submissions = Array();
  /**
  * @var array $comments array with id of comments related to the project
  */
  public $comments = Array();
  /**
  * @var DateTime $deadline DateTime object with the next deadline
  */
  public $deadline = null;
  /**
  * @var array $students array with id of students owning the project
  */
  public $students = Array();
  /**
  * @var array $managers array with id of managers related to the project
  */
  public $managers = Array();
  /**
  * @var array $examinators array with id of examinators related to the project
  */
  public $examinators = Array();
  /**
  * @var array $reviewers array with id of the reviewers related to the project
  */
  public $reviewers = Array();
  /**
  * @var array $feasible_reviewers array with id of the reviewers related to the project
  */
  public $feasible_reviewers = Array();

  /**
  * Constructor
  * @param  int   $id   id of the course to load
  * @param  obj   $dbh  database handle
  */
  public function __construct($id, $dbh = null)
  {
    // Setup database handle
    if ($dbh == null) {
      try {
          // Generate a database connection, using the PDO connector
          $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
      } catch (PDOException $e) {
          // If shit hits the fan
          throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
      }
    }
    else {
      try {
        // Check so the database handle is legit
        $dbh->getAttribute(PDO::ATTR_CONNECTION_STATUS);
        $this->dbh = $dbh;
      } catch (Exception $e) {
        throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
      }
    }

    // Get the project id
    $project = intval($id);
    if ($project <= 0) {
      throw new Exception("Invalid course id");
    }

    $sth = $this->dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
    $sth->bindParam(':id', $project, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    // If the project does not exists
    if (!$result) throw new Exception("Project does not exists");

    $this->id = $result->id;
    $this->subject = $result->subject;
    $this->stage = intval($result->stage);
    $this->grade = intval($result->grade);
    $this->submissions = unserialize($result->submissions);
    $this->comments = unserialize($result->comments);
    $this->deadline = new DateTime($result->deadline);
    $this->students = unserialize($result->students);
    $this->managers = unserialize($result->managers);
    $this->examinators = unserialize($result->examinators);
    $this->reviewers = unserialize($result->reviewers);
    $this->feasible_reviewers = unserialize($result->feasible_reviewers);
  }
}
