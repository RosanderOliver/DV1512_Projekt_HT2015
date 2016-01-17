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
  * @var int $select_projects To see if projects in this course can be selected
  */
  public $select_project = null;
  /**
  * @var array $admins Admin users for this course
  */
  private $admins = Array();
  /**
  * @var array $examinators Examinators assigned to this course
  */
  private $examinators = Array();
  /**
  * @var array $users Users assigned to this course
  */
  private $users = Array();
  /**
  * @var int $active To see if course is active
  */
  public $active = null;
  /**
  * Constructor
  * @param  int   $id   id of the course to load
  */
  public function __construct($id)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

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
    $this->select_project = intval($result->select_project);
    $this->admins = unserialize($result->admins);
    $this->examinators = unserialize($result->examinators);
    $this->users = unserialize($result->users);
    $this->active = intval($result->active);
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
  function addAdmin( $id )
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
  * @param int $id id of the admin to get
  * @return array|User
  */
  function getAdmin( $id = null )
  {
    // If no admin requested return whole array
    if ($id === null)
      return $this->admins;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0 || !in_array($id, $this->admins)) {
      throw new Exception("Invalid parameter");
    }

    return new User($id);
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to add
  * @return void
  */
  function addUser( $id )
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid parameter");
    }

    // Check if user is already assigned to the course
    if ($this->userIsAssigned($id)) {
      throw new Exception("User already assigned to course");
    }

    // Add user to users array
    $this->users[] = $id;
    $users = serialize($this->users);

    // Update database
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_USERS_WHERE_ID);
    $sth->bindParam(":users", $users, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to get
  * @return array|User
  */
  function getUser( $id = null )
  {
    // If no user requested return whole array
    if ($id === null)
      return $this->users;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0 || !in_array($id, $this->users)) {
      throw new Exception("Invalid parameter");
    }

    return new User($id);
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to add
  * @return void
  */
  function addExaminator( $id )
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid parameter");
    }

    // Add user to examinators array
    $this->examinators[] = $id;
    $examinators = serialize($this->examinators);

    // Update database
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_EXAMINATORS_WHERE_ID);
    $sth->bindParam(":examinators", $examinators, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to get
  * @return array|User
  */
  function getExaminator( $id = null )
  {
    // If no user requested return whole array
    if ($id === null)
      return $this->examinators;

    $id = intval($id);
    // Check for invalid id
    if ($id <= 0 || !in_array($id, $this->examinators)) {
      throw new Exception("Invalid parameter");
    }

    return new User($id);
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

  /**
  * @author Jim Ahlstrand
  * @param string $name name of the Course
  * @return Course the newly created course class
  */
  public static function createCourse($name)
  {
    // Check params
    if (empty($name) || strlen($name) > MAX_COURSE_NAME_LENGTH) {
      throw new Exception("Invalid course name");
    }

    $sth = $GLOBALS['dbh']->prepare(SQL_INSERT_COURSE);
    $sth->bindParam(":name", $name, PDO::PARAM_STR);
    $sth->execute();

    return new Course($GLOBALS['dbh']->lastInsertId());
  }

  /**
  * @author Annika Hansson
  * @param
  * @return updates if reviewers can select projects
  */
  function setSelectProject(){
    if($this->select_project == 0){
      $this->select_project = 1;
    }
    else{
      $this->select_project = 0;
    }

    //Update select_project
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_SELECT_PROJECTS_WHERE_ID);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->bindParam(":select_project", $this->select_project ,PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Annika Hansson
  * @param
  * @return updates if course is active or not
  */
  function setActiveCourse(){
    if($this->active == 0){
      $this->active = 1;
    }
    else{
      $this->active = 0;
    }

    //Update select_project
    $sth = $this->dbh->prepare(SQL_UPDATE_COURSE_ACTIVE_WHERE_ID);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->bindParam(":active", $this->active ,PDO::PARAM_INT);
    $sth->execute();
  }

  /**
  * @author Jim Ahlstrand
  * @param int $id id of the user to check
  * @return Bool true if user is assigned to this course
  */
  public function userIsAssigned($id)
  {
    return in_array($id, $this->users);
  }

}
