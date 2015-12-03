<?php

// TODO: Check if session data is correct befor adding it to database
// TODO: Create set functions to change user variables in user database
// TODO: Create settings database and settings class directly liked to from this class
// TODO: Create course class to directly link to course data
// TODO: Be able to create object for any requested user ( if permitted )

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
  public $courses = Array();

  /**
  * Constructor
  * @param  int   $id   id of the course to load
  * @param  obj   $dbh  database handle
  */
  public function __construct($id = null, $dbh = null)
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

    // Set the user id
    $user;
    if ($id == null) {
      $user = $_SESSION['user_name'];
    } else {
      $user = intval($id);
    }

    // Get user data
    // Prepare the statement
    $sth_get = $this->dbh->prepare(SQL_SELECT_USER_WHERE_EPPN);
    $sth_get->bindParam(':eppn', $user, PDO::PARAM_STR);
    $sth_get->execute();
    // Fetch the data
    $result = $sth_get->fetch(PDO::FETCH_OBJ);
    // Check if result is empty then add the user if it's not a given user id
    if (!$result && $id == null)
    {
      $sth_ins = $this->dbh->prepare(SQL_INSERT_USER);
      $sth_ins->bindParam(':eppn', $user, PDO::PARAM_STR);
      $sth_ins->bindParam(':email', $_SESSION['user_email'], PDO::PARAM_STR);
      $sth_ins->execute();
      // Try get the data agin
      $sth_get->execute();
      $result = $sth_get->fetch(PDO::FETCH_OBJ);
      if(!$result) throw new Exception("Unable to add user!");
    } else if (!$result) {
      // If user was given and doeas not exist in db
      throw new Exception("User does not exists");
    }

    // Add data to parameters
    $this->id = intval($result->id);
    $this->eppn = $result->eppn;
    $this->given_name = $result->given_name;
    $this->email = $result->email;
    $courseIDs = unserialize($result->courses);

    // Add course class for each courses
    foreach ($courseIDs as $key => $value) {
      /*$sth = $this->dbh->prepare(SQL_SELECT_COURSE_WHERE_ID);
      $sth->bindParam(':id', $value, PDO::PARAM_INT);
      $sth->execute();
      $this->courses[] = $sth->fetch(PDO::FETCH_OBJ);*/
      $this->courses[] = new Course($value, $dbh);
    }

    // Print it for tests
    prettyPrint($this);
  }
}
