<?php

// TODO: What is permissions table?

/**
* Handles course data and functions regarding handling data
* @author Jim Ahlstrand
*/
class Course
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
  * @var string $name Name of the course
  */
  public $name = "";
  /**
  * @var array $deadlines Array of the course's deadlines
  */
  public $deadlines = Array();
  /**
  * @var array $projects Projects assosiated with the course
  */
  private $projects = Array();
  /**
  * @var array $admins Admin users for this course
  */
  private $admins = Array();


  /**
  * Constructor
  * @param  int   $id   id of the course to load
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

    // Get the course id
    $course = intval($id);
    if ($course <= 0) {
      throw new Exception("Invalid course id");
    }

    $sth = $this->dbh->prepare(SQL_SELECT_COURSE_WHERE_ID);
    $sth->bindParam(':id', $course, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    // If the course does not exists
    if (!$result) throw new Exception("Could not find requested course");

    $this->id = $result->id;
    $this->name = $result->name;
    $this->deadlines = unserialize($result->deadlines);
    $this->projects = unserialize($result->projects);
    $this->admins = unserialize($result->admins);
  }

  /**
  * Get project data
  * @author Jim Ahlstrand
  * @param int, $id, Id of the project to be fetched defaults to null
  * @return obj, stdClassObject
  * TODO return only projects that the user own or has permission to view
  */
  function getProject( $id = null )
  {
    // If id is null return a list of all projects listed for the course
    if ($id === null)
      return $this->projects;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0)
      throw new Exception("Invalid parameter");

    // Check so project exists in the course
    if (!in_array($id, $this->projects))
      throw new Exception("Invalid project request");

    return new Project($id, $this->dbh);
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to add as admin
  * @return void
  */
  function addAdmin($id)
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid parameter");
    }

    // Add user to admins array
    $this->admins[] = $id;
    $admins = serialize($this->admins);

    // Update database
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_ADMINS_WHERE_ID);
    $sth->bindParam(":admins", $admins, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the project to add
  * @return void
  */
  function addProject($id)
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid parameter");
    }

    // Add project to projects array
    $this->projects[] = $id;
    $projects = serialize($this->projects);

    // Update database
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_PROJECTS_WHERE_ID);
    $sth->bindParam(":projects", $projects, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }
}
