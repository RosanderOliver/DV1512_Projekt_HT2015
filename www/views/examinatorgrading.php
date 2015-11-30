<?php
	$dataSent = 0;
	$correctgrade=false;
	$projectId=$_GET["id"];																												//TODO CHECK IF USER IS ALLOWED TO VIEW THIS ID
	$commentArr = array();

	$ssth = $dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
	$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
	$ssth->execute();
	$project=$ssth->fetchObject();

	$submissionsIndex = unserialize($project->submissions);
	$lastSubmissionIndex = $submissionsIndex[count($submissionsIndex) - 1];

	$ssth = $dbh->prepare(SQL_SELECT_FILES_WHERE_ID);
	$ssth->bindParam(":id", $project->fileid, PDO::PARAM_INT);										//TODO is it just one fileid, otherwise handle it
	$ssth->execute();
	$files = $ssth->fetchObject();

	$ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
	$ssth->bindParam(":id", $lastSubmissionIndex, PDO::PARAM_INT);								//TODO is it just one fileid, otherwise handle it
	$ssth->execute();
	$submission = $ssth->fetchObject();

	if($_POST){
		$grade = intval($_POST["grades"]);
		$comment = $_POST["comment"];

		if( $grade < 11 || $grade > 0 ) { 	//test grades
			$commentId=createComment($dbh);																						//TODO Inserts comment to database!

			if ($commentId != -1){
				$dataSent=1;

				if ($submission->comments == null) {
					$submission->comments=serialize($commentId);
				} else{
					$submissionArray = unserialize($submission->comments);
					$submissionArray .= " ".$commentId;
					$submission->comments = serialize($submissionArray);
				}

				$ssth = $dbh->prepare(SQL_UPDATE_SUBMISSION_COMMENTGRADE_WHERE_ID);
				$ssth->bindParam(":comments", $submission->comments, PDO::PARAM_STR);		//TODO SHOULD BE A SERIALIZED ARR
				$ssth->bindParam(":grade", $grade, PDO::PARAM_INT);
				$ssth->bindParam(":id", $lastSubmissionIndex, PDO::PARAM_INT);
				$ssth->execute();

				if ($grade > 2 && $grade < 9){
					$project->stage = $project->stage+1;
					$ssth = $dbh->prepare(SQL_UPDATE_PROJECT_STAGE_WHERE_ID);
					$ssth->bindParam(":stage", $project->stage, PDO::PARAM_INT);
					$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
					$ssth->execute();
				}
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


<?php
	$commentArr = getComment($dbh, $lastSubmissionIndex);
	echo "Student comment: ".$commentArr[0];


	for($x=0; $x < 1; $x++) {																											//TODO Shall loop over reviews
		echo "<br>Uploaded file: ";																									//TODO Name of uploaded files regarding this submission
		echo "<br>Reviewer: ";																											//TODO Reviewername
		echo "<br>Comment: ";																												//TODO Final comment from formulaty
		echo '<br><a href="Link to formulary">Link to formulary:</a>';							//TODO Link to formulary
		echo "<br>";
	}

?>

<hr>

<font color="#000000"><b>Final Grade Form</b></font>

<div >

			<br>
			Comment: (max 256 characters)<br /><?php  if ($dataSent == 1) : ?>
				<p> Data Sent </p>
				<?php
				echo "Grade: $grade <br>";
				echo "Comment: $comment";
				?>
			<?php elseif ($dataSent == 2) : ?>
				<p> Wrong input!!! </p>
				<?php echo $grade; ?>
			<?php  else : ?>
	<form method='post' action="?view=examinatorgrading&id=<?php echo $projectId; ?>">
		<?php if($project->stage == 3) : ?>
			<select name="grades">
		    <option value="4">A</option>
		    <option value="5">B</option>
		    <option value="6">C</option>
		    <option value="7">D</option>//MISSING USER AND SUBCOMMENT
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
	<input type='hidden' name="id" value='<?php echo $projectId; ?>' />
		<input type="submit" value="Submit grade and comment">
</form>
<?php endif; ?>
<br>
</div>