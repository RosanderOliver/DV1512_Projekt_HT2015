<?php

/**
 *  Defines common sql querys
 *  @author Jim Ahlstrand
 */

// User
define("SQL_SELECT_USER_WHERE_ID", "SELECT * FROM `login`.`users` WHERE `user_id`=:id");
define("SQL_SELECT_USER_WHERE_USER_NAME", "SELECT * FROM `login`.`users` WHERE `user_name`=:user_name");
define("SQL_UPDATET_USER_COURSES_WHERE_ID", "UPDATE `login`.`users` SET `user_courses`=:courses WHERE `user_id`=:id");

// Courses
define("SQL_INSERT_COURSE", "INSERT INTO `site`.`courses`(`name`) VALUES(:name)");
define("SQL_SELECT_COURSE_WHERE_ID", "SELECT * FROM `site`.`courses` WHERE `id`=:id");
define("SQL_UPDATE_COURSE_ADMINS_WHERE_ID", "UPDATE `site`.`courses` SET `admins`=:admins WHERE `id`=:id");

// Projects
define("SQL_SELECT_PROJECT_WHERE_ID", "SELECT * FROM `site`.`projects` WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_STAGE_WHERE_ID", "UPDATE `site`.`projects` SET `stage`=:stage WHERE id=:id");
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
define("SQL_INSERT_REVIEW", "INSERT INTO `site`.`reviews`(`user`, `date`, `data`) VALUES(:user,:date,:data)");
define("SQL_SELECT_REVIEW_WHERE_ID_AND_USER", "SELECT * FROM `site`.`reviews` WHERE `id`=:id AND `user`=:user");
define("SQL_SELECT_REVIEW_WHERE_ID", "SELECT * FROM `site`.`reviews` WHERE `id`=:id");
define("SQL_UPDATE_REVIEW_COMMENTS_WHERE_ID", "UPDATE `site`.`reviews` SET `comments`=:comments WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_FEASIBLE_REVIEWERS_WHERE_ID","UPDATE `site`.`projects` SET `feasible_reviewers`=:feasible_reviewers WHERE `id`=:id");
define("SQL_UPDATE_PROJECT_REVIEWERS_WHERE_ID","UPDATE `site`.`projects` SET `reviewers`=:reviewers WHERE `id`=:id");
