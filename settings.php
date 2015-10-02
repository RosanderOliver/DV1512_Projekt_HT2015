<?php

session_start(); //Open the session
$username = $_SESSION['username'];

?>

<html>
  <head>
    <title>Settings</title>
  </head>
  <body>

    <h3>Settings</h3>



    <div style="margin:10px 20px 10px 20px";><!--The whole site.. -->
        <div style="width:100%; height:40px; border:2px solid; margin:10px 0px 10px 0px"><!-- Some sort of menu :P -->
          <p style="float:left;"> Logged in as: <?php echo $username; ?></p>
          <p style="float:right;"><!-- Links --->
            <a href="./overview.php">Overview</a> |
            <a href="#">Profile</a> |
            <?php if ($username == "admin"){ echo "<a href='#'>Admin</a> |";}?> <!-- if admin, show this button -->
            <a href="./settings.php">Settings</a> |
            <a href="./index.php">Logout</a>
          </p>
        </div>


        Email:<input type="text" name="email" value="blabla@bla.bla"><br>
        Pswd:<input type="text" name="password" value="blabla@bla.bla"><br><br>

        <input type="submit" value="Update">

        <p>&copy; 2015 Projektgrupp X</p>
    </div><!--End of the whole site.. -->

  </body>
</html>
