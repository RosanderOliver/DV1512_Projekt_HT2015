<?php

// TODO: Check if session data is correct befor adding it to database
// TODO: Create set functions to change user variables in user database
// TODO: Create settings database and settings class directly liked to from this class
// TODO: Be able to create object for any requested user ( if permitted )
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
  private $dbh = null;
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
  * @param  obj   $dbh  database handle
  */
  public function __construct($id = null)
  {
    // Setup database handle
    try {
      // Generate a database connection, using the PDO connector
      $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $e) {
      // If shit hits the fan
      throw new Exception(MESSAGE_DATABASE_ERROR . $e->getMessage());
    }

    // Set the user id
    if ($id == null) {
      $user = $_SESSION['user_name'];
    } else {
      if ( intval($id) > 0) {
        $user = intval($id);
      } else {
        throw new Exception("Invalid user ID");
      }
    }

    // Get user data
    // If no userid was given look for the user currently logged in, this can't be assumed to be a valid user in database because of IDM atm
    if ($id == null) {
      $sth_get = $this->dbh->prepare(SQL_SELECT_USER_WHERE_EPPN);
      $sth_get->bindParam(':eppn', $user, PDO::PARAM_STR);
    } else {
      $sth_get = $this->dbh->prepare(SQL_SELECT_USER_WHERE_ID);
      $sth_get->bindParam(':id', $user, PDO::PARAM_INT);
    }
    $sth_get->execute();
    $result = $sth_get->fetch(PDO::FETCH_OBJ);

    // Check if result is empty then add the user if it's not a given user id
    if (!$result && $id == null)
    {
      $sth_ins = $this->dbh->prepare(SQL_INSERT_USER);
      $sth_ins->bindParam(':eppn', $user, PDO::PARAM_STR);
      $sth_ins->bindParam(':email', $_SESSION['user_email'], PDO::PARAM_STR);
      $sth_ins->bindParam(':given_name', $_SESSION['user_real_name'], PDO::PARAM_STR);
      $sth_ins->execute();
      // Try get the data agin
      $sth_get->execute();
      $result = $sth_get->fetch(PDO::FETCH_OBJ);
      if(!$result) throw new Exception("Unable to add user!");
    } else if (!$result) {
      // If user was given and doeas not exist in db
      throw new Exception("Could not find requested user");
    }

    // Add data to parameters
    $this->id = intval($result->id);
    $this->eppn = $result->eppn;
    $this->given_name = $result->given_name;
    $this->email = $result->email;
    $this->courses = unserialize($result->courses);
  }

  /**
  * Get course data
  * @author Jim Ahlstrand
  * @param int, $id, Id of the course to be fetched defaults to null
  * @return obj, Course
  */
  function getCourse( $id = null ) {

    // If id is null return a list of all courses listed for the User
    if ($id === null)
      return $this->courses;

      $id = intval($id);
      // Check for invalid id
      if ($id <= 0)
      throw new Exception("Invalid parameter");

    // Check so the course is listed for the user
    if (!in_array($id, $this->courses))
      throw new Exception("Invalid course request");

    return new Course($id, $this->dbh);
  }
}
