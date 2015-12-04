<?php
  if(isset($_GET['id'])){
    $submissionsId = $_GET['id'];
  }
  prettyPrint($submissionsId);

 if(isset($_POST['submit'])){

   $notEmpty = true;

     $data = new PP();
     $data->student1 = input_length(test_input($_POST["student1"]));
     $data->s1email = input_length(test_input($_POST["s1email"]));
     $data->pnr1 = input_length(test_input($_POST["pnr1"]));

     $data->student2 = input_length(test_input($_POST["student2"]));
     $data->s2email = input_length(test_input($_POST["s2email"]));
     $data->pnr2 = input_length(test_input($_POST["pnr2"]));

     $data->title = input_length(test_input($_POST["title"]));
     $data->course = input_length(test_input($_POST["course"]));
     $data->supervisor = input_length(test_input($_POST["supervisor"]));
     $data->term  = input_length(test_input($_POST["term"]));
     $data->type = input_length(test_input($_POST["type"]));

     $data->process1 = length_one(test_input(test_num($_POST["process1"])));
     $data->processcomment1 = input_length(test_input($_POST["processcomment1"]));
     $data->process2 = length_one(test_input(test_num($_POST["process2"])));
     $data->processcomment2 = input_length(test_input($_POST["processcomment2"]));
     $data->process3 = length_one(test_input(test_num($_POST["process3"])));
     $data->processcomment3 = input_length(test_input($_POST["processcomment3"]));
     $data->process4 = length_one(test_input(test_num($_POST["process4"])));
     $data->processcomment4 = input_length(test_input($_POST["processcomment4"]));

     $data->s1 = length_one(test_input(test_num($_POST["s1"])));

     $data->content1 = length_one(test_input(test_num($_POST["content1"])));
     $data->contentcomment1 = input_length(test_input($_POST["contentcomment1"]));
     $data->content2 = length_one(test_input(test_num($_POST["content2"])));
     $data->contentcomment2 = input_length(test_input($_POST["contentcomment2"]));
     $data->content3 = length_one(test_input(test_num($_POST["content3"])));
     $data->contentcomment3 = input_length(test_input($_POST["contentcomment3"]));
     $data->content4 = length_one(test_input(test_num($_POST["content4"])));
     $data->contentcomment4 = input_length(test_input($_POST["contentcomment4"]));

     $data->s2 = length_one(test_input(test_num($_POST["s2"])));

     $data->presentation1 = length_one(test_input(test_num($_POST["presentation1"])));
     $data->presentationcomment1 = input_length(test_input($_POST["presentationcomment1"]));
     $data->presentation2 = length_one(test_input(test_num($_POST["presentation2"])));
     $data->presentationcomment2 = input_length(test_input($_POST["presentationcomment2"]));
     $data->presentation3 = length_one(test_input(test_num($_POST["presentation3"])));
     $data->presentationcomment3 = input_length(test_input($_POST["presentationcomment3"]));
     $data->presentation4 = length_one(test_input(test_num($_POST["presentation4"])));
     $data->presentationcomment4 = input_length(test_input($_POST["presentationcomment4"]));
     $data->presentation5 = length_one(test_input(test_num($_POST["presentation5"])));
     $data->presentationcomment5 = input_length(test_input($_POST["presentationcomment5"]));

     $data->s3 = length_one(test_input(test_num($_POST["s3"])));
     $data->s4 = length_one(test_input(test_grade($_POST["s4"])));
     $data->feedback = input_length(test_input($_POST["feedback"]));

     $notEmpty = is_empty($data);

     if(notEmpty){

       if($dbh != null){
        $ssth = $dbh->prepare(SQL_INSERT_REVIEW);
        $uid = $_SESSION['user_id'];
        $ssth->bindParam(':user', $uid, PDO::PARAM_INT);
        $ssth->bindParam(':date', date("Y-m-d H:i:s"), PDO::PARAM_STR);
        $ssth->bindParam(':last_modified', date("Y-m-d H:i:s"), PDO::PARAM_STR);
        $ssth->bindParam(':data', serialize($data), PDO::PARAM_STR);
        $ssth->execute();
        $lastInsertId = $dbh->lastInsertId();
        insertReviewIdToSubmission($dbh, $submissionsId, $lastInsertId);

        echo "Your form has been saved.</br>";
       }
       else{
         echo "Connection failed. Try to log in again.</br>";
       }

     }
     else{
       include('includes/content/dp_pp-eval-supervisor.php');
     }


 }
 else{

     //have db connection
     if($dbh != null && $submissionsId != 0){
       //fin review from submission
       $sub = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
       $sub->bindParam(':id', $submissionsId, PDO::PARAM_INT);
       $sub->execute();
       $temp = $sub->fetchObject();

       $rIdArray = array();

       if($temp != null){
         $rIdArray = explode(" ",unserialize($temp->reviews));

       }

       $data = null;
       $uid = $_GET["uid"];
       $date = null;
       if(sizeof($rIdArray) > 1){
         for($i = 0; $i < sizeof($rIdArray); $i++){
           $ssth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID_AND_USER);
           $ssth->bindParam(':rid', $rIdArray[$i], PDO::PARAM_INT);
           $ssth->bindParam(':user', $uid, PDO::PARAM_INT);
           $ssth->execute();
           $tmp = $ssth->fetchObject();
           if(strtotime($date) < strtotime($tmp->date) || $date == null){
             $date = $tmp->date;
             $data = unserialize($tmp->data);
           }
         }
      }
      else{
        $ssth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID_AND_USER);
        $ssth->bindParam(':rid', $rIdArray[0], PDO::PARAM_INT);
        $ssth->bindParam(':user', $uid, PDO::PARAM_INT);
        $ssth->execute();
        $tmp = $ssth->fetchObject();
        if($tmp != null){
          echo "test";
          $data = unserialize($tmp->data);
        }
        //echo "data: " . $data->studen1;
      }
     }


   include('includes/content/dp_pp-eval-supervisor.php');

 }
