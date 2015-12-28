<?php

if (!defined("IN_EXM")) exit(1);

if ($login->isUserLoggedIn() === false) exit(1);

// Test permissions
if (!$user->hasPrivilege("canViewPermissions")) {
  header("Location: ?view=accessdenied");
}

$thead = array(
  'Permission'
);
$tdata = array();

// Add roles
foreach ($roles as $key => $value) {
  $thead[] = $value;
}

// Get all permissions from db
$get_perm = $GLOBALS['dbh']->prepare(SQL_SELECT_PERMISSIONS);
$get_perm->execute();

while( $permission = $get_perm->fetch(PDO::FETCH_OBJ) ) {
  $get_role = $GLOBALS['dbh']->prepare(SQL_SELECT_ROLES_WHERE_PERMISSION);
  $get_role->bindParam('perm_id', $permission->perm_id, PDO::PARAM_INT);
  $get_role->execute();

  $roleSet = array();
  while( $role = $get_role->fetch(PDO::FETCH_OBJ) ) {
    $roleSet[] = $role->role_id;
  }

  $row = array();
  $row[] = $permission->perm_desc;
  foreach ($GLOBALS['roles'] as $key => $value) {
    if (in_array($key, $roleSet)) {
      $row[] = "X";
    } else {
      $row[] = "";
    }
  }
  $tdata[] = $row;
}

printTable($thead, $tdata);

// Center table data fix
echo '<style>td{text-align:center}th{text-align:center}td:first-child{text-align:left}th:first-child{text-align:left}</style>';
