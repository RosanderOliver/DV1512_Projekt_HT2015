<?php

	//if() : //Skicka in argument som bestämmer betygsättningen
	//Need file.id!!!
	//Need projects.id!!!

	$decideFormula=false;	//True är examensarbetet false är projektplan
	$dataSent = 0;
	$correctgrade=false;


	$id=1;																							//USED TO IDENTYFT THE project
	$ssth = $dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
	$ssth->bindParam(":id", $id, PDO::PARAM_INT);
	$ssth->execute();
	$project=$ssth->fetchObject();

	$ssth = $dbh->prepare(SQL_SELECT_FILES_WHERE_ID);
	$ssth->bindParam(":id", $project->fileid, PDO::PARAM_INT);		//is it just one fileid, otherwise handle it
	$ssth->execute();
	$files = $ssth->fetchObject();

	print_r($project);
	echo "\n\n";
	print_r($files);

	if($_POST){
		$grade = intval($_POST["grades"]);
		$comment = $_POST["comment"];

		if( $grade < 11 || $grade > 0 ) { 	//test grades
			$dataSent=1;

			if ($dbh != null && ($project->stage == 2)){
				$id=1;																											//getid
				$ssth = $dbh->prepare(SQL_UPDATE_FILES_COMMENTGRADE_WHERE_ID);
				$ssth->bindParam(":comments", $comment, PDO::PARAM_STR);
				$ssth->bindParam(":grade", $grade, PDO::PARAM_INT);
				$ssth->bindParam(":id", $id, PDO::PARAM_INT);
				$ssth->execute();

				if ($grade == 3){
					$id=1;
					$project->stage = $project->stage+1;
					$ssth = $dbh->prepare(SQL_UPDATE_PROJECT_STAGE_WHERE_ID);
					$ssth->bindParam(":stage", $project->stage, PDO::PARAM_INT);
					$ssth->bindParam(":id", $id, PDO::PARAM_INT);
					$ssth->execute();
				}
			} elseif ($dbh != null && $project->stage == 3){

				//TODO

			}

		} else {
			$dataSent=0;
		}

	}


 ?>



<!-- ============ MIDDLE COLUMN (OVERVIEW) ============== -->
<td width="55%" valign="top" bgcolor="#FAFAFA">

<h2>Final Grade - Examinator</h2>
<br>


<h3><font color="darkblue">
<?php echo $project->subject;
			if($project->stage == 2){
				echo " | Project plan |";
			} elseif ($project->stage == 3) {
				echo " | Project report |";
			}


?>
 <font color="darkred"><?php echo "Deadline "; echo $project->deadline; ?></font></font></h3>

Uploaded File: <font color="purple"><?php echo $files->name; ?></font>

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
    <td>74</td>E
    <td>B</td>
  </tr>
</table>

<br><br><br>

<?php

  for($x=1; $x<4; $x++){  //Hämtar antalet reviwers
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
	<?php  if ($dataSent == 1) : ?>
		<p> Data Sent </p>
		<?php
		echo "Grade: $grade <br>";
		echo "Comment: $comment";
		?>
	<?php elseif ($dataSent == 2) : ?>
		<p> Wrong input!!! </p>
		<?php echo $grade; ?>
	<?php  else : ?>
			<br>
			Comment:<br />
	<form action="?view=examinatorgrading">
		<?php if($project->stage == 3) : ?>
			<select name="grades">
		    <option value="4">A</option>
		    <option value="5">B</option>
		    <option value="6">C</option>($grade =='A' || $grade == 'B' || $grade == 'C' || $grade == 'D' || $grade == 'E' || $grade == 'F' )
		    <option value="7">D</option>
		    <option value="8">E</option>
				<option value="9">Fx</option>
		    <option value="10">F</option>
		  </select>
		<?php elseif($project->stage == 2): ?>
			<select name="grades">
				<option value="3">G</option>
				<option value="2">Ux</option>
				<option value="1">U</option>
			</select>
		<?php endif; ?>

	<br>
	<br>
	<textarea name='comment' id='comment'></textarea><br /><br><br>
	<input type='hidden' name='articleid' id='articleid' value='<? echo $_GET["id"]; ?>' />
		<input type="submit" value="Submit grade and comment">
</form>
<br>
</form>

<?php  endif; ?>
