<?php

  for($x=1; $x<3; $x++){  //Hämtar antalet reviwers
    echo "<br>";
    echo "Reviwer $x <br>"; //Hämta namnen på reviewers
    echo "";
    echo "Grade: G <br>";  //Hämta deras slutbetyg
    echo "Comment: Really really good!";  //Hämta slukommenteraren
    echo '<form action="./PHP_Code/Submit_button.php" target="YO">
    <input type="submit" value="Open formulary"></form>'; //Öppnar Submit_button.php
  }

?>
