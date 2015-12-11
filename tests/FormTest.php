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
 class FormTest extends PHPUnit_Framework_TestCase
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


     //Test of the function test_num($data)
     $this->assertEquals(1, test_num(1));
     $this->assertEquals("-", test_num("-"));
     $this->assertEquals("-", test_num(10));


     //Test of the function test_input($data)
     $this->assertEquals("123", test_input("  123  "));   //trim() removes spaces before the first char and after the last one.
     $this->assertEquals("123'hihi\ttab", test_input("123\'hi\\hi\ttab")); //stripslashes() removes all slashes exept proper slashes like \t and \n etc.
     $this->assertEquals("&amp; &quot; &lt; &gt;", test_input("& \" < >")); //htmlspecialchars() changes some special characters to code that html can handle.


     //Test of the function is_empty($data)
     $this->assertEquals(false, is_empty(array('apple','banana ', ' cranberry ')));
     $this->assertEquals(false, is_empty(array('','', '')));
     $temp[10] = "something";
     $this->assertEquals(false, is_empty($temp));


     //Test of the function input_length()
     $string128 = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
     $string129 = "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaab";
     $this->assertEquals($string128, input_length($string129));   // <--- This function does not work


     //Test of the function length_one()
     $this->assertEquals("1", length_one("12345"));   // <--- This function does not work


   }








 }




 ?>
