<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `site`.`users` WHERE `id`= :id");
define("SQL_SELECT_USER_WHERE_EPPN", "SELECT * FROM `site`.`users` WHERE `eppn`= :eppn");
define("SQL_INSERT_USER", "INSERT INTO `site`.`users` (`eppn`, `user_email`) VALUES (:eppn, :user_email)");

//reviewer
define("SQL_SELECT_PROJECTS","SELECT * FROM `site`.`projects`");
define("SQL_INSERT_USER_AS_FEASIBLE_REVIEWERS","INSERT INTO `site`.`projects` WHERE `feasible_reviewers`=:feasible_reviewers");
