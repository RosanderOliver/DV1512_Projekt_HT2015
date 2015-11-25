<?php
	$dataSent = false;
	if($_POST){
		$dataSent=true;
		$grade = $_POST["grades"];
		$comment = $_POST["comment"];
	}


 ?>



<!-- ============ MIDDLE COLUMN (OVERVIEW) ============== -->
<td width="55%" valign="top" bgcolor="#FAFAFA">

<h2>Final Grade - Examinator</h2>
<br>


<h3><font color="darkblue">EX-Job: Flying Cars | Version 1.0 | <font color="darkred">Deadline: 2015-08-20</font></font></h3>

Uploaded File: <font color="purple">flyingcars_danton.pdf</font>

<br>
<br>
<table style="width:100%">
  <tr>
    <th>Reviewer</th>
    <th>Subject</th>
    <th>Quality</th>
    <th>Stuff</th>
    <th>Limits</th>$_POST
    <th>On</th>
    <th>Off</th>
    <th>Final Grade</th>
  </tr>
  <tr>
    <td>Alice</td>
    <td>34</td>
    <td>34</td>
    <td>51</td>
    <td>24</td>
    <td>14</td>
    <td>50</td>
    <td>A</td>
  </tr>
  <tr>
    <td>Bob</td>
    <td>34</td>
    <td>4</td>
    <td>24</td>
    <td>14</td>
    <td>1</td>
    <td>35</td>
    <td>C</td>
  </tr>
  <tr>
    <td>Chris</td>
    <td>34</td>
    <td>34</td>
    <td>22</td>
    <td>74</td>
    <td>3</td>
    <td>62</td>
    <td>B</td>
  </tr>
</table>

<br><br><br>

<?php

  for($x=1; $x<2; $x++){  //Hämtar antalet reviwers
    echo "<br>";
    echo "Reviwer $x <br>"; //Hämta namnen på reviewers
    echo "";
    echo "Grade: G <br>";  //Hämta deras slutbetyg
    echo "Comment: Really really good!";  //Hämta slukommenteraren
    echo '<form action="./PHP_Code/Subm Data Sent it_button.php" target="YO">
    <input type="submit" value="Open formulary"></form>'; //Öppnar Submit_button.php
  }

?>

<hr>

<font color="#000000"><b>Final Grade Form</b></font>

<form method='post'>




<?php  if($dataSent) : ?>
	<p> Data Sent </p>

	<?php
	echo "Grade: $grade <br>";
	echo "Comment: $comment";

	?>
<?php  else : ?>
		<br>
		Comment:<br />

<form action="?view=examinatorgrading">
	<select name="grades">
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="C">C</option>
    <option value="D">D</option>
    <option value="E">E</option>
    <option value="F">F</option>

  </select>
	<br>
	<br>
	<textarea name='comment' id='comment'></textarea><br /><br><br>
	<input type='hidden' name='articleid' id='articleid' value='<? echo $_GET["id"]; ?>' />
		<input type="submit" value="Submit grade and comment">
</form>
<br>
</form>

<?php  endif; ?>
