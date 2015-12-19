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
   protected static $subid;

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

     $user = 0;
     $date = date("Y-m-d H:i:s");
     $files = serialize(array());
     $reviews = serialize(array());
     $comments = serialize(array());
     $grade = 0;
     $stage = 0;

     // Insert the new submission
     $sth = self::$dbh->prepare(SQL_INSERT_SUBMISSION);
     $sth->bindParam(":user", $user, PDO::PARAM_INT);
     $sth->bindParam(':date', $date, PDO::PARAM_STR);
     $sth->bindParam(":files",$files, PDO::PARAM_STR);
     $sth->bindParam(":reviews", $reviews, PDO::PARAM_STR);
     $sth->bindParam(":comments", $comments, PDO::PARAM_STR);
     $sth->bindParam(":grade", $grade, PDO::PARAM_INT);
     $sth->bindParam(":stage", $stage, PDO::PARAM_INT);
     $sth->execute();

     // Add the submission
     self::$subid = intval(self::$dbh->lastInsertId());
   }

  public static function tearDownAfterClass()
  {
      $sth = self::$dbh->prepare(SQL_DELETE_SUBMISSION_WHERE_ID);
      $sth->bindParam(":id", self::$subid, PDO::PARAM_INT);
      $sth->execute();
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
     $sub = new Submission(self::$subid);
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
