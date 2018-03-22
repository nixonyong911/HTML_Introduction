<?php
	include 'TOP.inc';
	include 'change.inc';
	if (isset($_POST["studentID"])){
		$studentID	= trim($_POST["studentID"]);
		$score = trim($_POST["score"]);
		if (!$studentID=="" and !$score == ""){
			require_once("settings.php");
			$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
			if(!$conn){
				echo "Unable to connect Server.";
			} else {
				$query = "UPDATE `attempts` SET `score`='$score' WHERE studentID = '$studentID'";
				mysqli_query($conn, $query);
				$query = "SELECT * FROM attempts WHERE studentID LIKE '$studentID'";
				$result = mysqli_query($conn, $query);
				if(!$result){
					echo "<p>Something is wrong with ", $query, "</p>";
				} else {
					if(mysqli_num_rows($result)>0) {
						echo "Update successful.";
						mysqli_free_result($result);
					} else{
						echo "Student not found.";
					}
				}
				mysqli_close($conn);
			}
		}
	}
	include 'BOTTOM.inc';
?>