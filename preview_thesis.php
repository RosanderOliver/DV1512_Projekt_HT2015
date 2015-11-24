<?php

echo "Thesis eval</br>";

if($_POST){
  require 'class_thesis.php';
  require 'functions.php';

  echo "Done.</br>";

  $form = new thesis_eval();

  $form->student1 = test_input($_POST["student1"]);
  $form->s1email = test_input($_POST["s1email"]);
  $form->pnr1 = test_input($_POST["pnr1"]);

  $form->student2 = test_input($_POST["student2"]);
  $form->s2email = test_input($_POST["s2email"]);
  $form->pnr2 = test_input($_POST["pnr2"]);

  $form->title = test_input($_POST["title"]);
  $form->supervisor = test_input($_POST["supervisor"]);
  $form->thesistype = test_input($_POST["thesistype"]);

  $form->process1 = test_input(test_num($_POST["process1"]));
  $form->process2 = test_input(test_num($_POST["process2"]));
  $form->process3 = test_input(test_num($_POST["process3"]));
  $form->process4 = test_input(test_num($_POST["process4"]));

  $form->s1 = test_input(test_num($_POST["s1"]));

  $form->content1 = test_input(test_num($_POST["content1"]));
  $form->content2 = test_input(test_num($_POST["content2"]));
  $form->content3 = test_input(test_num($_POST["content3"]));

  $form->s2 = test_input(test_num($_POST["s2"]));

  $form->contribution1 = test_input(test_num($_POST["contribution1"]));
  $form->contribution2 = test_input(test_num($_POST["contribution2"]));
  $form->contribution3 = test_input(test_num($_POST["contribution3"]));

  $form->s3 = test_input(test_num($_POST["s3"]));

  $form->presentation1 = test_input(test_num($_POST["presentation1"]));
  $form->presentation2 = test_input(test_num($_POST["presentation2"]));
  $form->presentation3 = test_input(test_num($_POST["presentation3"]));
  $form->presentation4 = test_input(test_num($_POST["presentation4"]));
  $form->presentation5 = test_input(test_num($_POST["presentation5"]));

  $form->s4 = test_input(test_num($_POST["s4"]));
  $form->s5 = test_input(test_num($_POST["s5"]));
  $form->s6 = test_input(test_grade($_POST["s6"]));

  $form->impression = test_input($_POST["impression"]);
  $form->rname = test_input($_POST["rname"]);
  $form->date = test_input($_POST["date"]);
  $form->feedback = test_input($_POST["feedback"]);

  echo serialize($form);

}
else{
  echo "No submissions.</br>";
}



 ?>
