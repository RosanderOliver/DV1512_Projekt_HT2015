<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `site`.`users` WHERE `id`= :id");
define("SQL_SELECT_USER_WHERE_EPPN", "SELECT * FROM `site`.`users` WHERE `eppn`= :eppn");
define("SQL_INSERT_USER", "INSERT INTO `site`.`users` (`eppn`, `user_email`) VALUES (:eppn, :user_email)");

//Projects
define("SQL_SELECT_PROJECT_WHERE_ID", "SELECT * FROM `site`.`projects` WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_STAGE_WHERE_ID", "UPDATE `site`.`projects` SET `stage`=:stage WHERE `id`=:id");

//Files
define("SQL_SELECT_FILES_WHERE_ID", "SELECT * FROM `site`.`files` WHERE `id`=:id");
define("SQL_UPDATE_FILES_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`files` SET `comments`=:comments, `grade`=:grade WHERE `id`=:id");

//Submissions
define("SQL_SELECT_SUBMISSION_WHERE_ID", "SELECT * FROM `site`.`submissions` WHERE `id`=:id");
define("SQL_UPDATE_SUBMISSION_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`submissions` SET `comments`=:comments, `grade`=:grade WHERE `id`=:id");
define("SQL_UPDATE_SUBMISSION_REVIEWS_WHERE_ID", "UPDATE `site`.`submissions` SET `reviews`=:reviews WHERE `id`=:id");

//Comments
define("SQL_SELECT_COMMENTS_WHERE_ID", "SELECT * FROM `site`.`comments` WHERE `id`=:id");
define("SQL_INSERT_COMMENTS", "INSERT INTO `site`.`comments` (`user`, `date`, `data`, `subcomments`) VALUES (:user, :date, :data, :subcomments)");

//reviewer
define("SQL_INSERT_REVIEW","INSERT INTO `site`.`reviews`(`user`, `date`, `last_modified`, `data`) VALUES(:user,:date,:last_modified,:data)");
define("SQL_SELECT_REVIEW_WHERE_ID_AND_USER","SELECT * FROM `site`.`reviews` WHERE `id` = :rid AND `user`=:user");
define("SQL_SELECT_REVIEW_WHERE_ID","SELECT * FROM `site`.`reviews` WHERE `id` = :rid");
