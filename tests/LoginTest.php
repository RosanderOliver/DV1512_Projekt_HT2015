<?php

  class LoginTest extends PHPUnit_Framework_TestCase
  {
    public function testConstruct()
    {
      $a = new Login();
      $this->assertNotNull($a);
      $this->assertEquals(Array(), $a->errors)
    }
  }
