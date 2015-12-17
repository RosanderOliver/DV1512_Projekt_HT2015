<?php
if (!defined("IN_EXM")) exit(1);
if ($login->isUserLoggedIn() === false) exit(1);
echo "<center>";

if (isset($_POST)) {
  $username = $_POST['username'];
}



?>

<form method='post' action="?view=assignAdministrator">

  <INPUT TYPE = "Text" VALUE = "" NAME = "username">
	<INPUT TYPE = "Submit" VALUE = "Search for username">

</form>

<?php

  if (isset($username)) {

    //$ssth = $dbh->prepare(SQL_SELECT_USER_WHERE_USER_NAME);
    //$ssth->bindParam(":user_name", $username, PDO::PARAM_STR);
    //$ssth->execute();
    //$foundUser = $ssth->fetchObject();

    prettyPrint($dbh);
    prettyPrint($_POST['username']);

    $temp = 1;
    $ssth = $dbh->prepare(SQL_SELECT_USER_WHERE_ID);
    $ssth->bindParam(":id", $temp, PDO::PARAM_INT);
    $ssth->execute();
    $foundUser = $ssth->fetchObject();

    prettyPrint($founduser);
  }
