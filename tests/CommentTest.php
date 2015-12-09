<?php
  session_start();
  $_SESSION['user_id'] = 1;
  $_SESSION['user_name'] = 'admin';

  /**
   * Comment Test
   * Test class used to test functionality of Comment class
   * @author Jim Ahlstrand
   */
  class CommentTest extends PHPUnit_Framework_TestCase
  {

    /**
     * Test Add Comment
     * Test so the comment class adds a comment to the database
     * @author Jim Ahlstrand
     * @small
     * @test
     */
    public function addComment()
    {
      $data = "Test Comment, set test";
      $comment = new Comment(null, $data);
    }

    /**
     * Test get Comment
     * Test so the comment class gets a comment from the database
     * @author Jim Ahlstrand
     * @small
     * @test
     */
    public function getComment()
    {
      $data = "Test Comment, get test";
      $comment = new Comment(null, $data);
      $getComment = new Comment($comment->id);
      $this->assertEquals($data, $getComment->data);
    }
  }
