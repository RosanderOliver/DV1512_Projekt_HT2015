
<?php

  /*  Database Manager

        Creates and manages the database connection

      @user       string, username
      @password   string, password
      @host       string, ip to the database
      @port       int, portnumber for database
   */
class DBM {

  // Properties
  private $con    = NULL;

  // Construct & Destruct
  function __construct( $user, $password, $host, $port = 3300) {
    $this->con = new mysqli($host, $user, $password) or die ('Could not connect to the database server' . mysqli_connect_error());
    /* check connection */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
  }
  function __destruct() {
    $this->con->close();
  }

  // Methods

  /* Get Data

      Makes a query to the database and returns data

    @sql        string, query to make
    @return     array, array with the rows of data
  */
  public function getData( $sql ) {
    $ret = array();
    // Make query
    if ($result = $this->con->query( $sql )) {
      // Get rows of data
      while ($row = $result->fetch_row()) {
        $ret[] = $row;
      }
      // Close connection
      $result->close();

    } else {
      return FALSE;
    }
    return $ret;
  }

  /* Query

      Makes a query to the database

    @sql        string, query to make
    @return     bool, false if error
  */
  public function query( $sql ) {
    // Make query
    if ($result = $this->con->query( $sql )) {
      return TRUE;
    } else {
      return FALSE;
    }
  }


  /* Set DB

      Sets current db name

    @db       string, name of the database to use
    @return   void
  */
  public function setDB( $db ) {
    $this->con->select_db( $db );
  }
}
