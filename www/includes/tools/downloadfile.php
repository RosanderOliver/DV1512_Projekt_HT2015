<?php

  class Files {
    private $path;
    private $user;
    private $date;
    private $path;
    private $can_read;
    private $virus_searched;
    private $dbh;

    function __construct($dbh, $id=null) {
      $this->dbh = $dbh;

      if ($id == null && isset($_FILES)) {
        //SAVE Files

      }
      else if (intval($id) > 0) {
        
      }
    }




  }









 ?>
