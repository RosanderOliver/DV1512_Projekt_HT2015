<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `login`.`users` WHERE `user_id`=:id");
define("SQL_SELECT_USER_WHERE_USER_NAME", "SELECT * FROM `login`.`users` WHERE `user_name`=:user_name");

// Courses
define("SQL_SELECT_COURSE_WHERE_ID", "SELECT * FROM `site`.`courses` WHERE `id`=:id");

// Projects
define("SQL_SELECT_PROJECT_WHERE_ID", "SELECT * FROM `site`.`projects` WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_STAGE_WHERE_ID", "UPDATE `site`.`projects` SET stage=:stage WHERE id=:id");
define("SQL_UPDATE_PROJECT_SUBMISSION_WHERE_ID", "UPDATE `site`.`projects` SET `submissions`=:submissions WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_STAGESUBMISSION_WHERE_ID", "UPDATE `site`.`projects` SET `stage`=:stage, `submissions`=:submissions WHERE `id`=:id");

// Files
define("SQL_SELECT_FILES_WHERE_ID", "SELECT * FROM `site`.`files` WHERE `id`=:id");
define("SQL_UPDATE_FILES_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`files` SET `comments`=:comments, `grade`=:grade WHERE `id`=:id");

// Submissions
define("SQL_SELECT_SUBMISSION_WHERE_ID", "SELECT * FROM `site`.`submissions` WHERE `id`=:id");
define("SQL_DELETE_SUBMISSION_WHERE_ID", "DELETE FROM `site`.`submissions` WHERE `id`=:id");
define("SQL_UPDATE_SUBMISSION_COMMENTGRADE_WHERE_ID", "UPDATE `site`.`submissions` SET `comments`=:comments, `grade`=:grade WHERE `id`=:id");
define("SQL_UPDATE_SUBMISSION_REVIEWS_WHERE_ID", "UPDATE `site`.`submissions` SET `reviews`=:reviews WHERE `id`=:id");
define("SQL_INSERT_SUBMISSION", "INSERT INTO `site`.`submissions` (`user`, `date`, `files`, `reviews`, `comments`, `grade`, `stage`) VALUES (:user, :date, :files, :reviews, :comments, :grade, :stage)");

// Comments
define("SQL_SELECT_COMMENT_WHERE_ID", "SELECT * FROM `site`.`comments` WHERE `id`=:id");
define("SQL_INSERT_COMMENT", "INSERT INTO `site`.`comments` (`user`, `date`, `data`, `subcomments`) VALUES (:user, :date, :data, :subcomments)");

// Reviews
define("SQL_UPDATE_REVIEW_COMMENTS_WHERE_ID", "UPDATE `site`.`reviews` SET `comments`=:comments WHERE `id`=:id");
define("SQL_INSERT_REVIEW","INSERT INTO `site`.`reviews`(`user`, `date`, `data`) VALUES(:user,:date,:data)");
define("SQL_SELECT_REVIEW_WHERE_ID_AND_USER","SELECT * FROM `site`.`reviews` WHERE `id`=:id AND `user`=:user");
define("SQL_SELECT_REVIEW_WHERE_ID", "SELECT * FROM `site`.`reviews` WHERE `id`=:id");

define("SQL_SELECT_PROJECTS","SELECT * FROM `site`.`projects`");
define("SQL_SELECT_PROJECTS_WHERE_SUBJECT","SELECT * FROM `site`.`projects` WHERE `subject`=:subject");
define("SQL_UPDATE_PROJECT_FEASIBLE_REVIEWERS_WHERE_ID","UPDATE `site`.`projects` SET `feasible_reviewers`=:feasible_reviewers WHERE `id`=:id");
