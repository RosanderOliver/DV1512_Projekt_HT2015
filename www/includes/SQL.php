<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `site`.`users` WHERE `id`=");
define("SQL_INSERT_USER", "INSERT INTO `site`.`users` (`eppn`, `user_email`) VALUES (':eppn', ':user_email')");