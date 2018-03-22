<?php	
	include 'TOP.inc';
	require_once("settings.php");
	$conn = @mysqli_connect($host, $user, $pwd, $sql_db);
	if(!$conn){
		echo "Unable to connect Server.";
	} else {
		$errMsg = "";
		//santitise and validate the data
		list($errMsg, $studentID) = sanitiseAndValidate($_POST["studentID"], "int", "student ID", $errMsg);
		list($errMsg, $firstName) = sanitiseAndValidate($_POST["firstName"], "String", "first name", $errMsg);
		list($errMsg, $lastName) = sanitiseAndValidate($_POST["lastName"], "String", "last name", $errMsg);
		if ($errMsg != ""){
			echo $errMsg;
		} else {
			checkTable($conn);
			$attempt = checkStudent($conn, $studentID, $firstName, $lastName );
			$errMsg = "";
			//question 1
			if(!isset($_POST["q1"])){
				$errMsg .= "<p>question 1 not selected</p>";
			} else {
				$q1 = $_POST["q1"];
			}
			//question 2
			if(!isset($_POST["q2"])){
				$errMsg .= "<p>question 2 not selected</p>";
			} else {
				$q2 = $_POST["q2"];
			}	
			//question 3
			$q3 = array();
			$i = 0; //q3 counter;
			if(isset($_POST["q3a"])){ $q3[$i] = "q3a"; $i++;}
			if(isset($_POST["q3b"])){ $q3[$i] = "q3b"; $i++;}
			if(isset($_POST["q3c"])){ $q3[$i] = "q3c"; $i++;}
			if(isset($_POST["q3d"])){ $q3[$i] = "q3d"; $i;}
			if(empty($q3)){ $errMsg .= "<p>question 3 not selected</p>"; }
			//question 4
			if(!isset($_POST["q4"])){
				$errMsg .= "<p>question 4 not selected</p>";
			} else {
				$q4 = $_POST["q4"];
			}
			//question 5
			$q5 = trim(stripslashes(htmlspecialchars($_POST["q5"])));
			if($q5 == ""){
				$errMsg .= "<p>question 5 not answered</p>";
			}
			
			//for($i = 0; $i < sizeof($q3); $i++){
			//	echo $q3[$i];
			//}
			if ($errMsg != ""){
				echo $errMsg;
			} else if ((int)$attempt < 3){
				$score = checkResult($q1, $q2, $q3, $q4, $q5);
				//If score 0
				if ($score == 0){
					echo "<p>You have scored 0, please try again. <a href=\"../quiz.html\" id=\"button\">Back</a></p>";
				} else{ //did normal in test
					$attempt++;
					$query = "UPDATE `attempts` SET `attempts`='$attempt',`score`='$score' WHERE studentID = '$studentID'";	
					mysqli_query($conn, $query);
					echo "Submit successfully.";
					displayTable($conn, $studentID);
					echo "<p><a href=\"../quiz.html\" id=\"button\">Back</a></p>";
				}
			} else { //attempts more than 3
				echo "Unable to submit, you have reached maximum attempts.";
				echo "<p><a href=\"../quiz.html\" id=\"button\">Back</a></p>";
			}
		}
	}
		
	mysqli_close($conn);
	
	
	function displayTable($conn, $studentID){
		$query = "SELECT * FROM `attempts` INNER JOIN Student ON Student.studentID=attempts.studentID WHERE Student.studentID = '$studentID';";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "<p>Something is wrong with ", $query, "</p>";
		} else{
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
	}
	
	function checkResult($q1, $q2, $q3, $q4, $q5){
		$score = 0;
		if ($q1 == "q1a")
			$score++;
		
		if ($q2 == "q2b")
			$score++;
		
		if (in_array("q3a", $q3) == "" & in_array("q3b", $q3) == "1" & in_array("q3c", $q3) == "" & in_array("q3d", $q3) == "q3d")
			$score++;
		
		if ($q4 == "2011")
			$score++;
		
		if ($q5 == "2")
			$score++;
		
		return $score;
	}
	
	function sanitiseAndValidate($data, $datatype, $dataValue, $errMsg){
		$data = trim($data); //remove leading or trailing spaces
		$data = preg_replace('/[^a-zA-Z0-9]*/', '', $data); //remove all special characters;
		//$data = stripslashes($data); //Remove blackslashes in front of quotes
		//$data = htmlspecialchars($data); //Converts HTML control characters like < to the HTML code &lt;
		if ($datatype =="String"){	
			if ($data ==""){
			$errMsg .= "<p>You must enter your $dataValue.</p>";
			} else if (!preg_match("/^[a-zA-Z]*$/",$data)){
				$errMsg .= "<p>Only alpha letters allowed in your $dataValue.</p>";
			}
		} else{
			if ($data ==""){
			$errMsg .= "<p>You must enter your $dataValue.</p>";
			} else if (!is_numeric($data)){
				$errMsg .= "<p>Only numeric letters allowed in your $dataValue.</p>";
		} 	else if(!preg_match("/^(\d{7}|\d{10})*$/", $data)){
				$errMsg .= "<p>$dataValue can only be 7 or 10.</p>";
			}
		}
		return array($errMsg, $data);
	}
	
	function checkTable($conn){
		//Query for creating attempt table 
		
		$tableQuery = "CREATE TABLE attempts (
			attemptID 	INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			studentID	VARCHAR(10) NOT NULL,
			dateAndTime	DATETIME NOT NULL, 
			attempts	INT(1) NOT NULL,
			score	INT(2) NOT NULL,
			CONSTRAINT fk_student FOREIGN KEY(studentID)
			REFERENCES student(studentID)
			ON DELETE CASCADE
			ON UPDATE CASCADE
		 );";
		
		$studentQuery	="CREATE TABLE Student(
		studentID VARCHAR(10) NOT NULL,
		firstName VARCHAR(20) NOT NULL,
		lastName VARCHAR(20) NOT NULL,
		DOB VARCHAR(10),
		sex VARCHAR(6) NOT NULL,
		FOREIGN KEY (studentID) REFERENCES attempts(studentID)
		);";
		
		
		//Check if attmempt table exist or not.
		if(mysqli_query($conn,"SHOW TABLE LIKE 'attempts';") === FALSE){
			mysqli_query($conn, $tableQuery);
		} 
		if(mysqli_query($conn,"SHOW TABLE LIKE 'Student';") === FALSE){
			mysqli_query($conn, $studentQuery);
		} 
		
	}
	
	
	function checkStudent($conn, $studentID, $firstName, $lastName){
		$studentFound = FALSE;
		$attempt = "";
		$query = mysqli_query($conn,"SELECT * FROM attempts WHERE studentID = '$studentID';");
		//while loop to check whether student exist/attempt
		while($row = mysqli_fetch_assoc($query)){
			if($row["studentID"] == $studentID){
				$studentFound = TRUE;
				$attempt = $row["attempts"];
			} 
		}
		//If its student 1st attempt, it will add user into database.
		if(!$studentFound){
			$DOB = $_POST["DOB"];
			$sex = $_POST["sex"];
			$query = "INSERT INTO `attempts`(`dateAndTime`, `studentID` , `attempts`) VALUES (now(),'$studentID', '0')";
			mysqli_query($conn,$query);
			$query = "INSERT INTO `Student`(`StudentID`, `firstName`, `lastName`, `DOB`, `SEX`) VALUES ('$studentID','$firstName','$lastName', '$DOB', '$sex')";
			mysqli_query($conn,$query);
		}
		
		return $attempt;
	}
	include 'BOTTOM.inc';
?>