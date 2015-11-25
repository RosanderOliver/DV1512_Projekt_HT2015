<?php

// TODO: Get user from the session variable directly
// TODO: Create user if no user was found
// TODO: Create set functions to change user variables in user database
// TODO: Create settings database and settings class directly liked to from this class
// TODO: Create course class to directly link to course data

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
    $sth = $this->dbh->prepare(SQL_SELECT_USER_WHERE_EPPN);
    // Bind parameters
    $eppn = 'admin';
    $sth->bindParam(':eppn', $eppn, PDO::PARAM_STR);
    // Execute the statement
    $sth->execute();
    // Fetch the data
    $result = $sth->fetch(PDO::FETCH_OBJ);
    // Print it for tests
    print_r($result);
  }
}
