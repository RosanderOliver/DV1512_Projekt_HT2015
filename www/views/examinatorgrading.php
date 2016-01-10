<?php

	if (!defined("IN_EXM")) exit(1);
	if ($login->isUserLoggedIn() === false) exit(1);

	$tableTE = array(
	  1 => 'Reviewer',
	  2 => 'Process',
	  3 => 'Content',
	  4 => 'Contribution',
	  5 => 'Presentation',
	  6 => 'Grade' );

	$tablePP = array(
	  1 => 'Reviewer',
	  2 => 'Process',
	  3 => 'Content',
	  4 => 'Presentation',
	  5 => 'Grade' );

	$dataSent = 0;

	// Get project id
	if (isset($_GET['pid']) && intval($_GET['pid']) > 0) {
	  $pid = intval($_GET['pid']);
	} else {
	  exit('Invalid id!');
	}

	// Get submission id
	if (isset($_GET['sid']) && intval($_GET['sid']) > 0) {
		$sid = intval($_GET['sid']);
	} else {
		exit('Invalid id!');
	}

	$project = new Project($pid);
	$submission = $project->getSubmission($sid);
	$reviews = array();
	foreach ($submission->getReview() as $key => $value) {
		$id = $submission->getLatestReview($key);
		$reviews[] = $submission->getReview($id);
	}

	// Check form data
	if (!empty($_POST)) {

		$grade = intval($_POST["grades"]);
		$comment = $_POST["comment"];

		// TODO define stages with regards to defenitions for easier reading
		if( $grade < 11 || $grade > 0 ) {

			$dataSent = 1;

			$submission->addComment($comment);
			$submission->setGrade($grade);

			if ($grade > 2 && $grade < 9) {
				$project->updateStage();
			}

			if ($grade < 4 || $grade > 8) {
				$project->createSubmission();
			}

		} else {
			$dataSent = 0;
		}

		echo '<h3>Success!</h3><a href="?"><button class="btn btn-success">Go back</button></a>';
	} else {
 ?>


<h2>Final Grade - Examinator</h2>

<h3><font color="darkblue">
<?php

		echo $project->subject;
		echo ' | '.$GLOBALS['stages'][$project->stage].' |';

 		echo '<font color="darkred">';
	 	echo " Deadline ";
		echo $project->deadline->format("Y-m-d H:m:s");
		echo '</font></font></h3>';

		$thead = array();
		$tdata = array();
		foreach ($submission->getReview() as $key => $value) {
			// Get the review
			$id = $submission->getLatestReview($key);
			$review = $submission->getReview($id);
			$data = $review->data;

			// Get the table header
			if (get_class($data) == "TE") {
				$thead = $tableTE;
			} elseif (get_class($data) == "PP") {
				$thead = $tablePP;
			}

			$user = new User($review->user);

			// Get the table data
			if (get_class($data) == "TE") {

				$tdata[] = array(
					1 => $user->real_name,
					2 => $data->s1,
					3 => $data->s2,
					4 => $data->s3,
					5 => $data->s4,
					6 => $data->s6	);


			} elseif (get_class($data) == "PP") {

				$tdata[] = array(
					1 => $user->real_name,
					2 => $data->s1,
					3 => $data->s2,
					4 => $data->s3,
					5 => $data->s4 );
			}
		}

	// Print table
	printTable($thead, $tdata);

	// Print comments
	$comments = $submission->getComments();
	echo "<br><br>";
	echo "Student comment: ";
	if (isset($comments[0])) {
		echo $comments[0]->data;
	}
	echo "<br>Uploaded files: ";
	echo "<br><br>";																								//TODO Name of uploaded files regarding this submission
	foreach ($submission->getReview() as $key => $value) {
		// Get the review

		$id = $submission->getLatestReview($key);
		$review = $submission->getReview($id);
		echo "<br>Overall comments and feedback: ".$review->data->feedback;
		if (get_class($review->data) == "TE"){
			echo '<br><a target="_blank" href="?view=reviewthesis&sid='.$submission->id.'&uid='.$review->user.'">Link to REVIEWS NAMES REVIEW FORMULARY</a>';							//TODO Link to formulary should be the name of the reviewer
		} elseif (get_class($review->data) == "PP") {
			echo '<br><a target="_blank" href="?view=reviewplan&sid='.$submission->id.'&uid='.$review->user.'">Link to REVIEWS NAMES REVIEW FORMULARY</a>';
		}
			echo "<br><br>";
	}

//TODO form needs cleanup, use form class
?>

<hr>

<font color="#000000"><b>Final Grade Form</b></font>

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
	<form method='post' action="?view=examinatorgrading&pid=<?php echo $project->id; ?>&sid=<?php echo $submission->id; ?>">
		<?php if($project->stage >= 3) : ?>
			<select name="grades">
		    <option value="4">A</option>
		    <option value="5">B</option>
		    <option value="6">C</option>
		    <option value="7">D</option>
		    <option value="8">E</option>
				<option value="9">Fx</option>
		    <option value="10">F</option>
		  </select>
		<?php else: ?>
			<select name="grades">
				<option value="3">G</option>
				<option value="2">Ux</option>
				<option value="1">U</option>
			</select>
			<?php endif; ?>

	<br>
	<br>
	<textarea name='comment' id='comment'></textarea><br /><br><br>
	<input type='hidden' name="id" value='<?php echo $project->id; ?>' />
		<input type="submit" value="Submit grade and comment">
</form>
<?php endif; } ?>
