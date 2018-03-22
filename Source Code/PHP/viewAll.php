<?php
	include 'TOP.inc';
	include 'viewAll.inc';
	require_once("settings.php");
	$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
	if(!$conn){
		echo "Unable to connect Server.";
	} else {
		$sort = "attemptID";
		if(isset($_POST["sort"]) != "")
			$sort = $_POST["sort"];
		
		$order = "ASC";
		if(isset($_POST["order"]) != "")
			$order = $_POST["order"];
		$query = "SELECT * FROM attempts INNER JOIN Student ON Student.studentID=attempts.studentID ORDER BY $sort $order";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "<p>Something is wrong with ", $query, "</p>";
		} else {
			echo "<table border=\"1\">";
			echo "<tr>"
				 ."<th scope =\"col\">Attempt ID</th>"
				 ."<th scope =\"col\">Date And Time</th>"
				 ."<th scope =\"col\">First Name</th>"
				 ."<th scope =\"col\">Last Name</th>"
				 ."<th scope =\"col\">Student ID</th>"
				 ."<th scope =\"col\">Attmepts</th>"
				 ."<th scope =\"col\">Score</th>"
				 ."</tr>";
			while ($row = mysqli_fetch_assoc($result)){
				echo "<tr>";
				echo "<td>",$row["attemptID"],"</td>";
				echo "<td>",$row["dateAndTime"],"</td>";
				echo "<td>",$row["firstName"],"</td>";
				echo "<td>",$row["lastName"],"</td>";
				echo "<td>",$row["studentID"],"</td>";
				echo "<td>",$row["attempts"],"</td>";
				echo "<td>",$row["score"],"</td>";
				echo "</tr>";
			}
			echo "</table>";
			mysqli_free_result($result);
		}
		mysqli_close($conn);
	}
	include 'BOTTOM.inc';
?>