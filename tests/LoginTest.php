<?php


  /**
   * Tests Login Class
   * How to use PHPUnit:
   * @see https://phpunit.de/manual/current/en/
   */

  /**
   * Login Test
   * Test class used to test functionality of Login class
   * @author Jim Ahlstrand
   * @runTestsInSeparateProcesses
   */
  class LoginTest extends PHPUnit_Framework_TestCase
  {

    /**
     * Prepares each test
     * @author Jim Ahlstrand
     */
    public static function setUpBeforeClass()
    {
      // Do not use cookies
      ini_set('session.use_cookies', '0');
      // Include translations
      include_once("www/includes/translations/en.php");
    }

    /**
     * Test Constructor
     * Test so the Login class can be constructed
     * @author Jim Ahlstrand
     * @small
     * @test
     */
    public function construct()
    {
      // Create new login class
      $a = new Login();
      // Check so it's not null
      $this->assertNotNull($a);
      // Also check so there is no errors
      $this->assertEquals(Array(), $a->errors);
    }

    /**
     * Test user logged in
     * Tests if the user is logged in
     * @author Jim Ahlstrand
     * @dataProvider DataLogin
     * @small
     * @test
     */
    public function userLoggedIn($user_name, $password, $expected)
    {
      // Test so user isn't logged in
      $a = new Login();
      $this->assertFalse($a->isUserLoggedIn());

      // Now add some test data
      $_POST['login'] = true;
      $_POST['user_name'] = $user_name;
      $_POST['user_password'] = $password;

      // Recreate login class, now with login data
      $a = new Login();
      $this->assertEquals($expected, $a->isUserLoggedIn());

      // Try logout
      $a->doLogout();
      $this->assertFalse($a->isUserLoggedIn());
    }

    /**
     * Data provider for userLoggedIn
     * Contains test data
     * @author Jim Ahlstrand
     */
    public function DataLogin()
    {
      return array(
        array('admin', '123456', true),
        array('invalid', 'user', false)
      );
    }
  }
