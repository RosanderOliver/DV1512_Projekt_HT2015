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
   public function formFunctions()
   {
     // Create new user class
     $a = new PP();
     // Check if the object was created
     $this->assertNotNull($a);
     // Adding some variables into the form class PP
     $a->student1   = "StudentName";
     $this->assertEquals("StudentName", $a->student1);

   }
 }
 ?>
