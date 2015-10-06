<?php

session_start(); //Open the session
$username = $_SESSION['username'];

?>

<html>
  <head>
    <title>Overview</title>
  </head>
  <body>

    <h3>Overview</h3>


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


        <?php if ($username == "admin" || $username == "user") {?>  <!-- Show this only if admin/user is logged in. -->

          <div style="float:left; width:60%; height:300px; border:2px solid; margin:10px 10px 10px 0px"><!-- News feed table -->
            News feed
          </div>
          <div style="float:right; width:36%; height:300px; border:2px solid; margin:10px 10px 10px 0px"><!-- Course table -->
            Courses
            <div style="float:right; width:90%; height:30px; border:2px solid; margin:10px 10px 10px 10px">
              <a href="./course.php">Course_project</a>
            </div>
          </div>
          <div style="float:right; width:36%;height:100px; border:2px solid; margin:10px 10px 10px 0px"><!-- Assignment table -->
            Assignments
          </div>

        <?php } elseif ($username == "reviewer"){?> <!-- Closes the user part and start the reviewer part-->

          <div style="float:left; width:100%; height:300px; border:2px solid; margin:10px 10px 10px 0px">
            <p>Course: BLABLA</p>
            <table style="width:100%; ">
              <tr>
                <td><b>Course</b></td>
                <td><b>Student</b></td>
                <td><b>Reviewed</b></td>
                <td><b>Other</b></td>
                <td><b>Review</b></td>
              </tr>
              <tr style="background-color: rgba(0, 0, 0, 0.14);">
                <td>Example Course</td>
                <td>Example Student</td>
                <td>No</td>
                <td>Someting something..</td>
                <td><a href="./review.php">Edit</a></td>
              </tr>
              <tr>
                <td>Example Course</td>
                <td>Example Student x2</td>
                <td>Yes</td>
                <td>Someting something..</td>
                <td><a href="./review.php">Edit</a></td>
              </tr>
              <tr style="background-color: rgba(0, 0, 0, 0.14);">
                <td>Example Course</td>
                <td>Example Student x3</td>
                <td>No</td>
                <td>Someting something..</td>
                <td><a href="./review.php">Edit</a></td>
              </tr>
            </table>
          </div>

        <?php } else die();?><!-- Closes the reviewer part -->

      <p>&copy; 2015 Projektgrupp X</p>
    </div>

  </body>
</html>
