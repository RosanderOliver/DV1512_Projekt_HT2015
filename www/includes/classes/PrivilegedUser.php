<?php

/**
* @author Jim Ahlstrand
*/
class PrivilegedUser extends User
{

  /**
  * @var constant int ADMIN         database id of the admin role
  * @var constant int EXAMINATOR    database id of the examinator role
  * @var constant int REVIEWER      database id of the reviewer role
  * @var constant int MANAGER       database id of the manager role
  * @var constant int STUDENT       database id of the student role
  * @var constant int COURSEADMIN   database id of the courseadmin role
  */
  const ADMIN        = 1;
  const EXAMINATOR   = 2;
  const REVIEWER     = 3;
  const MANAGER      = 4;
  const STUDENT      = 5;
  const COURSEADMIN  = 6;

  /**
  * @var array $roles array with the roles that the user has
  */
  private $roles = array();

  /**
  * Constructor
  * @param  int   $id   id of the user to load
  */
  public function __construct($id = null) {
    parent::__construct($id);
    $this->initRoles();
  }

  /**
  * Gets the roles for this user
  * @author Jim Ahlstrand
  */
  protected function initRoles() {
    $sth = $this->dbh->prepare(SQL_SELECT_USER_JOIN_ROLE_WHERE_ID);
    $sth->bindParam(':user_id', $this->id, PDO::PARAM_INT);
    $sth->execute();

    while ($result = $sth->fetch(PDO::FETCH_OBJ)) {
      // Build the object
      $role = new Role($result->role_id);

      // Add it to the array
      $this->roles[$result->role_name] = $role;
    }
  }

  /**
  * Check if user has a specific privilege
  * @author Jim Ahlstrand
  * @param string $permission name of the permission to check
  */
  public function hasPrivilege($permission) {
    foreach ($this->roles as $role) {
      if ($role->hasPerm($permission)) {
        return true;
      }
    }
    return false;
  }

  /**
  * Add role to user
  * @author Jim Ahlstrand
  * @param int $role id of the role to add
  */
  public function addRole($role) {

    // Check role id
    if ($role < 1 || $role > 6) {
      throw new Exception("Invalid role");
    }

    // Get the role
    $sth = $this->dbh->prepare(SQL_SELECT_ROLES_WHERE_ID);
    $sth->bindParam(':role_id', $this->id, PDO::PARAM_INT);
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_OBJ);

    // Build the object
    $role = new Role($role);
    $this->roles[$result->role_name] = $role;

    return false;
  }
}
