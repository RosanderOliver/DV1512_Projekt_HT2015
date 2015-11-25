<?php

// TODO: Setup database connection and get user data
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
    
  }
}
