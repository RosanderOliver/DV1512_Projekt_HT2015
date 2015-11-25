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
  public $courses = null;

  /**
   * Constructor
   */
  public function __construct()
  {
    // Setup database handle
    try {
        // Generate a database connection, using the PDO connector
        $this->dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
    } catch (PDOException $e) {
        // If shit hits the fan
        echo MESSAGE_DATABASE_ERROR . $e->getMessage();
        exit;
    }

    // Get user data
    // Prepare the statement
    $sth_get = $this->dbh->prepare(SQL_SELECT_USER_WHERE_EPPN);
    // Bind parameters
    $sth_get->bindParam(':eppn', $_SESSION['user_name'], PDO::PARAM_STR);
    // Execute the statement
    $sth_get->execute();
    // Fetch the data
    $result = $sth_get->fetch(PDO::FETCH_OBJ);
    // Check if result is empty then add the user
    if(!$result)
    {
      $sth_ins = $this->dbh->prepare(SQL_INSERT_USER);
      $sth_ins->bindParam(':eppn', $_SESSION['user_name'], PDO::PARAM_STR);
      $sth_ins->bindParam(':email', $_SESSION['user_email'], PDO::PARAM_STR);
      $sth_ins->execute();
      // Try get the data agin
      $sth_get->execute();
      $result = $sth_get->fetch(PDO::FETCH_OBJ);
      if(!$result) throw new Exception("Unable to add user!");
    }
    // Print it for tests
    print_r($result);
  }
}
