<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `site`.`users` WHERE `id`= :id");
define("SQL_SELECT_USER_WHERE_EPPN", "SELECT * FROM `site`.`users` WHERE `eppn`= :eppn");
define("SQL_INSERT_USER", "INSERT INTO `site`.`users` (`eppn`, `user_email`) VALUES (:eppn, :user_email)");

//projects
define("SQL_SELECT_PROJECT_WHERE_ID", "SELECT * FROM `site`.`projects` WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_STAGE_WHERE_ID", "UPDATE `site`.`projects` SET stage=:stage WHERE id=:id");

//files
define("SQL_SELECT_FILES_WHERE_ID", "SELECT * FROM `site`.`files` WHERE `id`=:id");
define("SQL_UPDATE_FILES_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`files` SET comments=:comments, grade=:grade WHERE id=:id");

//Submissions
define("SQL_UPDATE_SUBMISSION_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`submissions` SET comments=:comments, grade=:grade WHERE id=:id");
