<?php

  /**
   * Functions Test
   * Test class used to test functionality of Functions
   * @author Jim Ahlstrand
   */
  class FunctionsTest extends PHPUnit_Framework_TestCase
  {

    /**
     * Test printULLink
     * @author Jim Ahlstrand
     * @small
     * @test
     */
    public function printullink()
    {
      $testdata = array(
        array("label", null),
        array("label"),
        array("label", array(
          array("sublabel", null)
        ))
      );

      printULLink($testdata);
    }


  }
