<?php

// TODO: Check if session data is correct before adding it to database (IDM)
// TODO: Create settings database and settings class directly liked to from this class
// TODO: Correctly fetch users instead of eppn, this is a work around for dual stacking IDM

/**
 *  User object to handle user data
 *  @author Jim Ahlstrand
 */
class User
{
  /**
  * @var object $dbh The database handler
  */
  protected $dbh = null;
  /**
  * @var string $user The usersname
  */
  public $user = "";
  /**
  * @var int $id The user's database id
  */
  public $id = null;
  /**
  * @var string $eppn The user's edu personal principal name
  */
  public $eppn = "";
  /**
  * @var string $given_name The user's given name
  */
  public $given_name = "";
  /**
  * @var string $email The user's mail
  */
  public $email = "";
  /**
  * @var array $courses The user's courses
  */
  private $courses = Array();

  /**
  * Constructor
  * @param  int   $id   id of the user to load
  */
  public function __construct($id = null)
  {
    // Setup database handle
    $this->dbh = $GLOBALS['dbh'];

    // Set the user id
    if ($id == null) {
      $user = $_SESSION['user_id'];
    } else {
      if (intval($id) > 0) {
        $user = intval($id);
      } else {
        throw new Exception("Invalid user ID");
      }
    }

    // Get user data
    $sth = $this->dbh->prepare(SQL_SELECT_USER_WHERE_ID);
    $sth->bindParam(':id', $user, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    if (!$result) {
      // If user does not exist in db
      throw new Exception("Could not find requested user");
    }

    // Add data to parameters
    $this->id         = intval($result->user_id);
    $this->name       = $result->user_name;
    $this->real_name  = $result->user_real_name;
    $this->email      = $result->user_email;
    $this->courses    = unserialize($result->user_courses);
  }

  /**
  * Get course data
  * @author Jim Ahlstrand
  * @param int, $id, Id of the course to be fetched defaults to null
  * @return obj, Course
  */
  function getCourse( $id = null )
  {
    // If id is null return a list of all courses listed for the User
    if ($id === null)
      return $this->courses;

      $id = intval($id);
      // Check for invalid id
      if ($id <= 0)
      throw new Exception("Invalid parameter");

    // Check so the course is listed for the user
    if ( !in_array($id, $this->courses) )
      throw new Exception("Invalid course request");

    return new Course($id);
  }

  /**
  * Adds courseID to user
  * @author Jim Ahlstrand
  * @param int $id course id to add
  * TODO Check so course exists
  */
  function addCourse($id)
  {
    $id = intval($id);
    // Check for invalid id
    if ($id <= 0) {
      throw new Exception("Invalid ID");
    }

    // Update this User
    $this->courses[] = $id;
    $courses = serialize($this->courses);

    // Update db
    $sth = $this->dbh->prepare(SQL_UPDATET_USER_COURSES_WHERE_ID);
    $sth->bindParam(":courses", $courses, PDO::PARAM_STR);
    $sth->bindParam(":id", $this->id, PDO::PARAM_INT);
    $sth->execute();

  }
}
