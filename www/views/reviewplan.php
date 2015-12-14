<?php

  if (isset($_GET['sid']) && intval($_GET['sid']) > 0) {
    $sid = intval($_GET['sid']);
  } else {
    exit("Invalid submission");
  }

  $submission = new Submission($sid);

  if (isset($_POST['submit'])) {

   $form = new PP();
   $form->student1 = test_input($_POST["student1"]);
   $form->s1email = test_input($_POST["s1email"]);
   $form->pnr1 = test_input($_POST["pnr1"]);

   $form->student2 = test_input($_POST["student2"]);
   $form->s2email = test_input($_POST["s2email"]);
   $form->pnr2 = test_input($_POST["pnr2"]);

   $form->title = test_input($_POST["title"]);
   $form->course = test_input($_POST["course"]);
   $form->supervisor = test_input($_POST["supervisor"]);
   $form->term  = test_input($_POST["term"]);
   $form->type = test_input($_POST["type"]);

   $form->process1 = test_input(test_num($_POST["process1"]));
   $form->processcomment1 = test_input($_POST["processcomment1"]);
   $form->process2 = test_input(test_num($_POST["process2"]));
   $form->processcomment2 = test_input($_POST["processcomment2"]);
   $form->process3 = test_input(test_num($_POST["process3"]));
   $form->processcomment3 = test_input($_POST["processcomment3"]);
   $form->process4 = test_input(test_num($_POST["process4"]));
   $form->processcomment4 = test_input($_POST["processcomment4"]);

   $form->s1 = test_input(test_num($_POST["s1"]));

   $form->content1 = test_input(test_num($_POST["content1"]));
   $form->contentcomment1 = test_input($_POST["contentcomment1"]);
   $form->content2 = test_input(test_num($_POST["content2"]));
   $form->contentcomment2 = test_input($_POST["contentcomment2"]);
   $form->content3 = test_input(test_num($_POST["content3"]));
   $form->contentcomment3 = test_input($_POST["contentcomment3"]);
   $form->content4 = test_input(test_num($_POST["content4"]));
   $form->contentcomment4 = test_input($_POST["contentcomment4"]);

   $form->s2 = test_input(test_num($_POST["s2"]));

   $form->presentation1 = test_input(test_num($_POST["presentation1"]));
   $form->presentationcomment1 = test_input($_POST["presentationcomment1"]);
   $form->presentation2 = test_input(test_num($_POST["presentation2"]));
   $form->presentationcomment2 = test_input($_POST["presentationcomment2"]);
   $form->presentation3 = test_input(test_num($_POST["presentation3"]));
   $form->presentationcomment3 = test_input($_POST["presentationcomment3"]);
   $form->presentation4 = test_input(test_num($_POST["presentation4"]));
   $form->presentationcomment4 = test_input($_POST["presentationcomment4"]);
   $form->presentation5 = test_input(test_num($_POST["presentation5"]));
   $form->presentationcomment5 = test_input($_POST["presentationcomment5"]);

   $form->s3 = test_input(test_num($_POST["s3"]));
   $form->s4 = test_input(test_grade($_POST["s4"]));
   $form->feedback = test_input($_POST["feedback"]);

   if (empty($data)) {

     if($dbh != null) {
       $user = $_SESSION['user_id'];
       $sth = $dbh->prepare(SQL_INSERT_REVIEW);
       $sth->bindParam(':user', $user, PDO::PARAM_INT);
       $sth->bindParam(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
       $sth->bindParam(':data', serialize($form), PDO::PARAM_STR);
       $sth->execute();
       $lastInsertId = $dbh->lastInsertId();

       $submission->addReview($lastInsertId);

      echo "Your form has been saved.</br>";
    } else {
        echo "Connection failed. Try to log in again.</br>";
      }

      echo "end </br>";
  }
} else {

       $rIdArray = array();

       if ($temp != null) {
         $rIdArray = unserialize($temp->reviews);
       }

       $data = null;
       $uid = $_GET["uid"];
       $date = null;
       if (sizeof($rIdArray) > 1) {
         for($i = 0; $i < sizeof($rIdArray); $i++){
           $sth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID_AND_USER);
           $sth->bindParam(':rid', $rIdArray[$i], PDO::PARAM_INT);
           $sth->bindParam(':user', $uid, PDO::PARAM_INT);
           $sth->execute();
           $tmp = $sth->fetchObject();
           if (strtotime($date) < strtotime($tmp->date) || $date == null) {
             $date = $tmp->date; $data = unserialize($tmp->data);
           }
         }
       } else {
         $sth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID_AND_USER);
         $sth->bindParam(':rid', $rIdArray[0], PDO::PARAM_INT);
         $sth->bindParam(':user', $uid, PDO::PARAM_INT);
         $sth->execute();
         $tmp = $sth->fetchObject();
         if($tmp != null){
           echo "test";
           $data = unserialize($tmp->data);
         }
         //echo "data: " . $data->studen1;
       }

   include('includes/content/dp_pp-eval-supervisor.php');
 }
