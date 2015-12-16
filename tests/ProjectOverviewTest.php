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
   protected static $dbh;
   protected static $proid;
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
     // Create new database handle
     try {
       // Generate a database connection, using the PDO connector
       self::$dbh = new PDO('mysql:host='. DB_HOST .';dbname='. DB_NAME . ';charset=utf8', DB_USER, DB_PASS);
     } catch (PDOException $e) {
       // If shit hits the fan
       throw new Exception($e->getMessage());
     }
     $subject = "Test Subject"; //asd
     $deadline = date("Y-m-d H:i:s");
     $students = serialize(array());
     $examinators = serialize(array());
     $submissions = serialize(array());
     $comments = serialize(array());
     $grade = null;
     $stage = 2;

     // Insert the new submission
     $sth = self::$dbh->prepare(SQL_INSERT_PROJECT);
     $sth->bindParam(":subject", $subject, PDO::PARAM_STR);
     $sth->bindParam(':deadline', $deadline, PDO::PARAM_STR);
     $sth->bindParam(":examinators", $examinators, PDO::PARAM_STR);
     $sth->bindParam(":students", $students, PDO::PARAM_STR);
     $sth->bindParam(":submissions", $submissions, PDO::PARAM_STR);
     $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
     $sth->bindParam(":grade", $grade, PDO::PARAM_INT);
     $sth->bindParam(":stage", $stage, PDO::PARAM_INT);
     $sth->execute();

     // Add the project
     self::$proid = intval(self::$dbh->lastInsertId());
   }
  public static function tearDownAfterClass()
  {
      $project = new Project(self::$proid);
      foreach ($project->getSubmission() as $key => $value) {
        $sth = self::$dbh->prepare(SQL_DELETE_SUBMISSION_WHERE_ID);
        $sth->bindParam(":id", $value, PDO::PARAM_INT);
        $sth->execute();
      }

      $sth = self::$dbh->prepare(SQL_DELETE_PROJECT_WHERE_ID);
      $sth->bindParam(":id", self::$proid, PDO::PARAM_INT);
      $sth->execute();
  }
   /**
    * Test projectFunctions
    * Testing the functions in the project- and submissionclass
    * @author Fredrik Andersson
    * @small
    * @test
    */
   public function projectFunctions()
   {
     //Project::
     // Create new project class
     $pro = new Project(self::$proid);
     // Check if the object was created
     $this->assertNotNull($pro);
     //Here we test if the updateStage() function works!
     $this->assertEquals(2, $pro->stage);
     $pro->updateStage();
     $this->assertEquals(3, $pro->stage);


     //Submission::
     //Create a submission to the project
     $pro->createSubmission();
     //Get the latest submission in the project
     foreach ($pro->getSubmission() as $key => $value){
       $sub = new Submission($value);
     }
     //Test to see if the grades are saved.
     $sub->grade = 2;
     $this->assertEquals(2, $sub->grade);


     //Comment
     

   }
 }
 ?>
