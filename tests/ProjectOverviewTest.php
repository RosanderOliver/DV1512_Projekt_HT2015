<?php
/**
 * Test Form
 * How tu use PHPUnit: https://phpunit.de/manual/current/en/
 */
 /**
  * Form Test
  * Test class used to test functionality of Login class
  * @author Fredrik Andersson
  */
 class ProjectOverviewTest extends PHPUnit_Framework_TestCase
 {
   /**
    * Prepares each test
    * @author Fredrik Andersson
    */
   public static function setUpBeforeClass()
   {
     // Include translations
     include_once("www/includes/translations/en.php");
     // Include translations
     include_once("www/includes/functions.php");
   }
   /**
    * Test savingForm
    * Test so a proper form is saved, with correct data.
    * Also test if it is possible to enter incorrect data that might ruin something.
    * @author Fredrik Andersson
    * @small
    * @test
    */
   public function submissionFunctions()
   {
     // Create new user class
     $sub = new Submission();
     // Check if the object was created
     $this->assertNotNull($sub);

     /*

     //Create a project!!!!
     $projectId=intval(1);
   	 $lastSubmissionIndex = intval(1);
     $projectClass = new Project($projectId);

     $grade = intval(); // 1=U, 2=Ux, 3=G

     if ($grade > 2 && $grade < 9) {
       $projectClass->updateStage();
     }
     */

   }
 }
 ?>
