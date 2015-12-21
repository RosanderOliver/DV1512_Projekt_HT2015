<?php

/**
* @author Jim Ahlstrand
*/
class Role
{
  /**
  * @var array $permissions array with the roles permissions as objects
  */
  protected $permissions = array();

  /**
  * Constructor
  * @param  int   $id   id of the role to load
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

    // Get the role id
    $role = intval($id);
    if ($role <= 0) {
      throw new Exception("Invalid role id");
    }

    $sth = $this->dbh->prepare(SQL_SELECT_ROLE_JOIN_PERMISSIONS_WHERE_ID);
    $sth->bindParam(':role_id', $role, PDO::PARAM_INT);
    $sth->execute();

    while ($result = $sth->fetch(PDO::FETCH_OBJ)) {
      // Build the object
      $perm = new stdClass;
      $perm->perm_name = $result->perm_name;
      $perm->perm_desc = $result->perm_desc;

      // Add it to the array
      $this->permissions[$result->perm_id] = $perm;
    }
  }

  /**
  * Check if a permission is set
  * @author Jim Ahlstrand
  * @param int $permission id of the permission to check for
  */
  public function hasPerm($permission) {
    return key_exists($permission, $this->permissions);
  }
}
