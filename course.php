<?php

session_start(); //Open the session
$username = $_SESSION['username'];

?>

<html>
  <head>
    <title>Course</title>
  </head>
  <body>

    <h3>Course</h3>


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


        <div style="float:left; width:100%; height:300px; border:2px solid; margin:10px 10px 10px 0px"><!-- News feed table -->

          <p>Course: <b>Course_project</b><br>
          StudentID: <b>Blabla</b></p>

          <table style="width:100%;">
            <tr>
              <td><b>Name</b></td>
              <td><b>Version</b></td>
              <td><b>File</b></td>
              <td><b>Grade</b></td>
              <td><b>Comment</b></td> 
              <td><b>Deadline</b></td>
            </tr>
            <tr>
              <td>Projectplan</td>
              <td>1</td>
              <td><a href="#">bla.doc</a></td>
              <td>ux</td>
              <td>bla bla</td>
              <td><s>16/01/14 23:59</s></td>
            </tr>
            <tr>
              <td></td>
              <td>2</td>
              <td><input type="submit" value="Upload file"></td>
              <td>g/ux/u</td>
              <td></td>
              <td>16/01/16 23:59</td>
            </tr>
            <tr height="10px"></tr>   <!-- Just to get some space between them!-->
            <tr>
              <td>Examensarbete</td>
              <td>1</td>
              <td><input type="submit" value="Upload file"></td>
              <td>g/ux/u</td>
              <td>Comment..</td>
              <td>16/07/28 12:00</td>
            </tr>
          </table>

        </div>



      <br>
      <p>&copy; 2015 Projektgrupp X</p>
    </div>

  </body>
</html>
