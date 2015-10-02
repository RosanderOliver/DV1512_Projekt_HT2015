<?php

  // Index file
  // Here we define variables used for database authentication

  // Set site variable
  define(IN_PR, TRUE);


?>

<html>
<head>
  <title>Startsida</title>
</head>
<link rel="stylesheet" href="css/stilmall.css" type="text/css" />
<body>

  <p>
    Submit your thesis here.</br>
  </p>

<form action="./login.php" method="post">
  Uername:
  <select name="name">
    <option value="admin">Admin</option>
    <option value="user">User</option>
    <option value="reviewer">Reviewer</option>
  </select></br>
  Password: <input type="password" name="psw"></br>
  <input type="submit" value="Login">
</form>

<p>&copy; 2015 Projektgrupp X</p>

</body>
</html>
