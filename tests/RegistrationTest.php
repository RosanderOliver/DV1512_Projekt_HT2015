<?php


  /**
   * Tests Registration Class
   * How to use PHPUnit:
   * @see https://phpunit.de/manual/current/en/
   */

  /**
   * Registration Test
   * Test class used to test functionality of Registration class
   * @author Jim Ahlstrand
   * @runTestsInSeparateProcesses
   */
  class RegistrationTest extends PHPUnit_Framework_TestCase
  {

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
      $a = new Registration();
      // Check so it's not null
      $this->assertNotNull($a);
      // Also check so there is no errors
      $this->assertEquals(Array(), $a->errors);
    }
  }
