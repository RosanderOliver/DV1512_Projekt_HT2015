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
define("SQL_INSERT_REVIEW","INSERT INTO `site`.`reviews`(`user`, `date`, `last_modified`, `data`) VALUES(:user,:date,:last_modified,:data)");
define("SQL_SELECT_REVIEW_WHERE_ID","SELECT * FROM `site`.`reviews` WHERE `id` = :rid");
