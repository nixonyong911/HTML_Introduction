<?php
		include 'TOP.inc';
		include 'viewOne.inc';
		$studentID = "";
		$studentName = "";
		if (isset($_POST["studentID"])){
			$studentID	= trim($_POST["studentID"]);
			$studentName = trim($_POST["studentName"]);
			if (!$studentID=="" or !$studentName==""){
				require_once("settings.php");
				$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
				if(!$conn){
					echo "Unable to connect Server.";
				} else {
					if(isset($_POST["studentID"]) != "")
						$studentID = $_POST["studentID"];
					else
						$studentName = $_POST["studentName"];
					echo $studentID;
					echo $studentName;
					if ($studentID != ""){
						$query = "SELECT * FROM attempts INNER JOIN Student ON Student.studentID=attempts.studentID WHERE Student.studentID = '$studentID'";
					} else {
						$query = "SELECT * FROM attempts INNER JOIN Student ON Student.studentID=attempts.studentID WHERE Student.firstName = '$studentName' OR Student.lastName ='$studentName'";
					}
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
						//echo "<p><a href=\"../quiz.html\" id=\"button\">Back</a></p>";
						mysqli_free_result($result);
					}
					mysqli_close($conn);
				}
			}
		}
		include 'BOTTOM.inc';
	?>