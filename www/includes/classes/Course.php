<?php

// TODO: What is permissions table?
// TODO: Add projects object directly linked to in projects array

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
  * @var int $role_table table id of permissions id
  */
  public $role_table = null;
  /**
  * @var int $deadlines Array of the course's deadlines
  */
  public $deadlines = Array();
  /**
  * @var int $projects projects assosiated with the course
  */
  public $projects = Array();

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
    if (!$result) throw new Exception("Course does not exists");

    $this->id = $result->id;
    $this->role_table = $result->role_table;
    $this->deadlines = unserialize($result->deadlines);
    $this->projects = unserialize($result->projects);
  }
}
