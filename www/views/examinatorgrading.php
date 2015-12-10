<?php
	$dataSent = 0;
	$correctgrade=false;
	$projectId=intval($_GET["pid"]);																												//TODO CHECK IF USER IS ALLOWED TO VIEW THIS ID
	$lastSubmissionIndex = intval($_GET["sid"]);
	$commentArr = array();
	$reviewIdArr = array();
	$reviewArr = array();
	$reviewArrData = array();
	$submissionsIndexArray = array();
	$submissionCommentIndex = array();

	$ssth = $dbh->prepare(SQL_SELECT_PROJECT_WHERE_ID);
	$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
	$ssth->execute();
	$project=$ssth->fetchObject();

	$ssth = $dbh->prepare(SQL_SELECT_SUBMISSION_WHERE_ID);
	$ssth->bindParam(":id", $lastSubmissionIndex, PDO::PARAM_INT);
	$ssth->execute();
	$submission = $ssth->fetchObject();
	$reviewIdArr = unserialize($submission->reviews);
	$submissionCommentIndex = unserialize($submission->comments);

	for($x = 0; $x < sizeof($reviewIdArr); $x++) {
		$ssth = $dbh->prepare(SQL_SELECT_REVIEW_WHERE_ID);
		$ssth->bindParam(":rid", $reviewIdArr[$x], PDO::PARAM_INT);
		$ssth->execute();
		$reviewArr[$x] = $ssth->fetchObject();
		$reviewArrData[$x] = unserialize($reviewArr[$x]->data);
	}


	if($_POST){
		$grade = intval($_POST["grades"]);
		$comment = $_POST["comment"];
		$newcomments;

		if( $grade < 11 || $grade > 0 ) {
			$commentId=createComment($dbh);
			if ($commentId != -1){
				$dataSent=1;
				$submissionCommentIndex[] = $commentId;
				$submissionCommentIndex = serialize($submissionCommentIndex);

				$ssth = $dbh->prepare(SQL_UPDATE_SUBMISSION_COMMENTGRADE_WHERE_ID);
				$ssth->bindParam(":comments", $submissionCommentIndex, PDO::PARAM_STR);
				$ssth->bindParam(":grade", $grade, PDO::PARAM_INT);
				$ssth->bindParam(":id", $lastSubmissionIndex, PDO::PARAM_INT);
				$ssth->execute();

				if ($grade < 4 || $grade > 8) {
					$newSubmission = createEmptySubmission($dbh);
					$submissionsIndexArray = unserialize($project->submissions);
					$submissionsIndexArray[] = intval($newSubmission);
					$submissionsIndexArray = serialize($submissionsIndexArray);
				}
				else {
					$submissionsIndexArray =	serialize($submissionsIndexArray);
				}

				if ($grade > 2 && $grade < 9) {
					$project->stage = $project->stage+1;
					$ssth = $dbh->prepare(SQL_UPDATE_PROJECT_STAGESUBMISSION_WHERE_ID);
					$ssth->bindParam(":stage", $project->stage, PDO::PARAM_INT);
					$ssth->bindParam(":submissions", $submissionsIndexArray, PDO::PARAM_STR);
					$ssth->bindParam(":id", $projectId, PDO::PARAM_INT);
					$ssth->execute();
				}
				else {
					$ssth = $dbh->prepare(SQL_UPDATE_PROJECT_STAGESUBMISSION_WHERE_ID);
					$ssth->bindParam(":stage", $project->stage, PDO::PARAM_INT);
					$ssth->bindParam(":submissions", $submissionsIndexArray, PDO::PARAM_STR);
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
			if($project->stage == 2) {
				echo " | Project plan |";
			} elseif ($project->stage == 3) {
				echo " | Project report |";
			}


?>
 <font color="darkred"><?php echo "Deadline "; echo $project->deadline; ?></font></font></h3>
<?php
	if (sizeof($reviewArr) > 0 ) {
		if (get_class($reviewArrData[0]) == "TE") {
			echo "&nbsp&nbspReviewer"."&nbsp&nbsp&nbsp"." Process"."&nbsp&nbsp"."Content"."&nbsp&nbsp"."Contribution"."&nbsp&nbsp"."Presentation"."&nbsp&nbsp"."Grade<br>";
		} elseif (get_class($reviewArrData[0]) == "PP"){
			echo "&nbsp&nbspReviewer"."&nbsp&nbsp&nbsp"." Process"."&nbsp&nbsp"."Content"."&nbsp&nbsp"."&nbsp&nbsp"."&nbsp&nbsp"."Grade<br>";
		}
		for($x=0; $x<sizeof($reviewArrData); $x++){
			if (get_class($reviewArrData[$x]) == "TE") {
				echo "&nbsp&nbsp&nbsp".$reviewArr[$x]->user."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";									//TODO Get reviewer name from correct table
				echo $reviewArrData[$x]->s1."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s2."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s3."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s4."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s6."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo "<br><br>";
			} elseif (get_class($reviewArrData[$x]) == "PP") {
				echo "&nbsp&nbsp&nbsp".$reviewArr[$x]->user."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";									//TODO Get reviewer name from correct table
				echo $reviewArrData[$x]->s1."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s2."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s3."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo $reviewArrData[$x]->s4."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				echo "<br><br>";
			}
		}
}


	$commentArr = getComment($dbh, $lastSubmissionIndex);
	echo "Student comment: ".$commentArr[0];
	echo "<br>Uploaded file: ";																										//TODO Name of uploaded files regarding this submission
	for($x=0; $x < sizeof($reviewArr); $x++) {
		echo "<br>Overall comments and feedback: ".$reviewArrData[$x]->feedback;
		if (get_class($reviewArrData[$x]) == "TE"){
			echo '<br><a target="_blank" href="/index.php?view=thesis&id='.$lastSubmissionIndex.'&uid='.$reviewArr[$x]->user.'">Link to REVIEWS NAMES REVIEW FORMULARY</a>';							//TODO Link to formulary should be the name of the reviewer
		} elseif (get_class($reviewArrData[$x]) == "PP") {
			echo '<br><a target="_blank" href="/index.php?view=pp&id='.$lastSubmissionIndex.'&uid='.$reviewArr[$x]->user.'">Link to REVIEWS NAMES REVIEW FORMULARY</a>';
		}
			echo "<br><br>";
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
	<form method='post' action="?view=examinatorgrading&pid=<?php echo $projectId; ?>&sid=<?php echo $lastSubmissionIndex; ?>">
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
