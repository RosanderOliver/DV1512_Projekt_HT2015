<?php

/**
* @author Jim Ahlstrand
*/
class PrivilegedUser extends User
{

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
  * check if user has a specific privilege
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
}
