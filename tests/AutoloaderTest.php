<?php


/**
 * Tests Autoloader
 * How tu use PHPUnit: https://phpunit.de/manual/current/en/
 */

/**
 * Autoloader Test
 * Test if the autoloader works
 * @author Fredrik Andersson
 */

 class LoginAutoloader extends PHPUnit_Framework_TestCase
 {

   /**
    * Prepares each test
    * @author Fredrik Andersson
    */
   public static function setUpBeforeClass()
   {
     // Include SQL.php- It's needed for the User class!
     include_once("www/includes/SQL.php");
     // Include translations
     include_once("www/includes/translations/en.php");
   }

   /**
    * Test loadingClass
    * Test so the Userclass can be constructed and some value can be set
    * @author Fredrik Andersson
    * @small
    * @test
    */
   public function loadingClass()
   {
     // Create new user class
     $a = new User();
     // Check so it's not null
     $this->assertNotNull($a);

     // Changing a value in the class
     $a->id = 123;

     // Check if it was succesfully changed
     $this->assertEquals(123, $a->id);

   }

  /**
  * Test loadingInvalidClass
  * Testing to load a class that does not exist.
  * @author Fredrik Andersson
  * @expectedException PHPUnit_Framework_Error
  * @small
  * @test
  */
   public function loadingInvalidClass()
   {
     // Trying to create a class that does not exist.
     //$a = new InvalidClass();

     // Testing to change value of id
     $a->id = 123;
     $this->assertEquals(123, $a->id);

   }

 }

?>
