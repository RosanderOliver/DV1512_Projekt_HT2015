<?php

session_start(); //Open the session
$username = $_SESSION['username'];

?>

<html>
  <head>
    <title>Review</title>
  </head>
  <body>

    <h3>Review</h3>

    <div style="margin:10px 20px 10px 20px";><!--The whole site.. -->

        <div style="width:100%; height:40px; border:2px solid; margin:10px 10px 10px 0px"><!-- Some sort of menu :P -->
          <p style="float:left;"> Logged in as: <?php echo $username; ?></p>
          <p style="float:right;"><!-- Links --->
            <a href="./overview.php">Overview</a> |
            <a href="#">Profile</a> |
            <?php if ($username == "admin"){ echo "<a href='#'>Admin</a> |";}?> <!-- if admin, show this button -->
            <a href="./settings.php">Settings</a> |
            <a href="./index.php">Logout</a>
          </p>
        </div>


        <div style="float:left; width:100%; border:2px solid; margin:10px 10px 10px 0px"><!--  -->

          <p>Student Name: <b>Blabla Bla</b></p>
          <p>Assignemt Name: <b>Example</b></p>
          <br>
          <table style="width:100%">
            <tr>
              <td width="10%">Kriterie 1</td>
              <td width="30%" height="100px" style="border:2px solid;"><p>Comment: asdasdasd asdasdasd asdasdasd. asdasdasdasdasd asdasd asd asdasd asdasdasd asd. asdasdasdasdasdasd. asdasdasd. asdasdasd. asdasdasd. </p></td>
              <td width="10%"><center>Grade</center></td>
            </tr>
            <tr height="10px"></tr>   <!-- Just to get some space between them!-->
            <tr>
              <td width="10%">Kriterie 2</td>
              <td width="30%" height="100px" style="border:2px solid;">Comment: asdasdasd asdasdasd asdasdasd. asdasdasdasdasd asdasd asd asdasd asdasdasd asd. asdasdasdasdasdasd. asdasdasd. asdasdasd. asdasdasd. </td>
              <td width="10%"><center>Grade</center></td>
            </tr>
            <tr height="10px"></tr>   <!-- Just to get some space between them!-->
            <tr>
              <td width="10%">Kriterie 2</td>
              <td width="30%" height="100px" style="border:2px solid;">Comment: asdasdasd asdasdasd asdasdasd. asdasdasdasdasd asdasd asd asdasd asdasdasd asd. asdasdasdasdasdasd. asdasdasd. asdasdasd. asdasdasd. </td>
              <td width="10%"><center>Grade</center></td>
            </tr>
          </table>
          <br><br>
        </div>


      <p>&copy; 2015 Projektgrupp X</p>
    </div>

  </body>
</html>
