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
  * @var int $id The project's database id
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
  private $submissions = Array();
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
  * @param  int   $id   id of the project to load
  * @param  obj   $dbh  database handle
  */
  public function __construct($id, $dbh = null)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

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
    if (!$result) throw new Exception("Could not find requested project");

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

  /**
  * Get submission data
  * @author Jim Ahlstrand
  * @param int, $id, Id of the submission to be fetched defaults to null
  * @return Submission|array
  * TODO return only submissions that the user own or has permission to view
  */
  public function getSubmission( $id = null )
  {
    // If id is null return a list of all submissions listed for the project
    if ($id === null)
      return $this->submissions;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0)
      throw new Exception("Invalid parameter");

    // Check so submission exists in the course
    if (!in_array($id, $this->submissions))
      throw new Exception("Invalid submission request");

    return new Submission($id);
  }

  /**
  * @author Annika Hansson
  * @param
  * @return void
  * @TODO adds feasible reviewers to database
  */

  function addFeasibleReviewer(){
    if(!in_array($_SESSION['user_id'],$this->feasible_reviewers)){
      $this->feasible_reviewers[] = intval($_SESSION['user_id']);
      $ssth = $this->dbh->prepare(SQL_UPDATE_PROJECT_FEASIBLE_REVIEWERS_WHERE_ID);
      $ssth->bindParam(':id', $this->id, PDO::PARAM_INT);
      $ssth->bindParam(':feasible_reviewers', serialize($this->feasible_reviewers), PDO::PARAM_STR);
      $ssth->execute();
    }
  }

    /**
    * @author Annika Hansson
    * @param int $rid Reviewer ID
    * @return void
    * @TODO adds reviewers to database
    */

    function addReviewer($rid){
      if(!in_array($rid,$this->reviewers)){
        $this->reviewers[] = intval($rid);
        $ssth = $this->dbh->prepare(SQL_UPDATE_PROJECT_REVIEWERS_WHERE_ID);
        $ssth->bindParam(':id', $this->id, PDO::PARAM_INT);
        $ssth->bindParam(':reviewers', serialize($this->reviewers), PDO::PARAM_STR);
        $ssth->execute();
      }
    }


  /**
  * @author Oliver Rosander, Jim Ahlstrand
  * @return void
  */
  public function createSubmission()
  {
    $user = 0;
    $date = date("Y-m-d H:i:s");
    $files = serialize(array());
    $reviews = serialize(array());
    $comments = serialize(array());
    $grade = 0;

    // Insert the new submission
    // TODO This should be a class
    $sth = $this->dbh->prepare(SQL_INSERT_SUBMISSION);
    $sth->bindParam(":user", $user, PDO::PARAM_INT);
    $sth->bindParam(':date', $date, PDO::PARAM_STR);
    $sth->bindParam(":files",$files, PDO::PARAM_STR);
    $sth->bindParam(":reviews", $reviews, PDO::PARAM_STR);
    $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
    $sth->bindParam(":grade", $grade, PDO::PARAM_INT);
    $sth->bindParam(":stage", $this->stage, PDO::PARAM_INT);
    $sth->execute();

    // Add the submission
    $this->submissions[] = intval($this->dbh->lastInsertId());
    // Update the Database
    $submissions = serialize($this->submissions);
    $sth = $this->dbh->prepare(SQL_UPDATE_PROJECT_SUBMISSION_WHERE_ID);
    $sth->bindParam(":submissions", $submissions, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Oliver Rosander, Jim Ahlstrand
  * @return void
  */
  public function updateStage()
  {
    $this->stage = $this->stage + 1;
    $sth = $this->dbh->prepare(SQL_UPDATE_PROJECT_STAGE_WHERE_ID);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->bindParam(":stage", $this->stage, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the student
  * @return void
  */
  function addStudent($id)
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid parameter");
    }

    // Add project to projects array
    $this->students[] = $id;
    $students = serialize($this->students);

    // Update database
    $sth = $this->dbh->prepare(SQL_UPDATE_PROJECT_STUDENTS_WHERE_ID);
    $sth->bindParam(":students", $students, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param string $subject subject of the project
  * @param array $examinators array with id of examinators
  * @param DateTime $deadline deadline of the project
  * @param int $stage starting stage of the project
  * @return Project
  */
  public static function createProject($subject, $examinators, $deadline, $stage)
  {
    // Check input
    if (empty($subject) || strlen($subject) > MAX_PROJECT_SUBJECT_LENGTH) {
      throw new Exception("Invalid parameter");
    }
    if (!is_array($examinators)) {
      throw new Exception("Invalid parameter");
    }
    if (!key_exists($stage, $GLOBALS['stages'])) {
      throw new Exception("Invalid parameter");
    }
    $examinators = serialize($examinators);
    $deadline = $deadline->format('Y-m-d H:i:s');

    $sth = $GLOBALS['dbh']->prepare(SQL_INSERT_PROJECT);
    $sth->bindParam(':subject', $subject, PDO::PARAM_STR);
    $sth->bindParam(':stage', $stage, PDO::PARAM_INT);
    $sth->bindParam(':examinators', $examinators, PDO::PARAM_STR);
    $sth->bindParam(':deadline', $deadline, PDO::PARAM_STR);
    $sth->execute();

    return new Project($GLOBALS['dbh']->lastInsertId());
  }

}
