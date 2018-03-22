<?php
	include 'TOP.inc';
	include 'reset.inc';
	if (isset($_POST["studentID"])){
		$studentID	= trim($_POST["studentID"]);
		if (!$studentID==""){
			require_once("settings.php");
			$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
			if(!$conn){
				echo "Unable to connect Server.";
			} else {
				$studentID = "";
				if(isset($_POST["studentID"]) != "")
					$studentID = $_POST["studentID"];
				$query = "UPDATE `attempts` SET `attempts`='0' WHERE studentID = '$studentID'";
				mysqli_query($conn, $query);
				$query = "SELECT * FROM attempts WHERE studentID LIKE '$studentID'";
				$result = mysqli_query($conn, $query);
				if(!$result){
					echo "<p>Something is wrong with ", $query, "</p>";
				} else {
					if(mysqli_num_rows($result)>0) {
						echo "Reset successful.";
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