<?php
  if(isset($_GET['id'])){
    $submissionsId = $_GET['id'];
  }
  prettyPrint($submissionsId);

 if(isset($_POST['submit'])){

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

   if($dbh != null){
    $ssth = $dbh->prepare(SQL_INSERT_REVIEW);
    $uid = $_SESSION['user_id'];
    $ssth->bindParam(':user', $uid, PDO::PARAM_INT);
    $ssth->bindParam(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
    $ssth->bindParam(':last_modified', date("Y-m-d H:i:s"), PDO::PARAM_STR);
    $ssth->bindParam(':data', serialize($form), PDO::PARAM_STR);
    $ssth->execute();
    $lastInsertId = $dbh->lastInsertId();
    insertReviewIdToSubmission($dbh, $submissionsId, $lastInsertId);

    echo "Your form has been saved.</br>";
   }
   else{
     echo "Connection failed. Try to log in again.</br>";
   }

   echo "end </br>";

 }
 else{

     //have db connection
     if($dbh != null && $submissionsId != 0){
       //fin review from submission
       $sub = $dbh->prepare(SQL_SELECT_SUBBMISSION_WHERE_ID);
       $sub->bindParam(':id', $submissionsId, PDO::PARAM_INT);
       $sub->execute();
       $tmp = $sub->fetchObject();
       $tmp = unserialize($tmp->reviews);

       if($tmp != null){
         $rIdArray = explode(" ",$tmp->reviews);
       }

       $uid = $_SESSION['user_id'];
       $date = null;
       for($i = 0; $i < $rIdArray.length; $i++){
         $ssth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID_AND_USER);
         $ssth->bindParam(':rid', $rid, PDO::PARAM_INT);
         $ssth->bindParam(':user', $uid, PDO::PARAM_INT);
         $ssth->execute();

         $tmp = $ssth->fetchObject();

         if($date->diff($tmp->date) || $date == null){
           $date = $tmp->date;
           $data = unserialize($tmp->data);
         }

       }


     }


   include('includes/content/dp_pp-eval-supervisor.php');

 }
