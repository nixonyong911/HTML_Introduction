<form method="post" action="view50.php">
	<fieldset><legend>Supervisor:</legend>
		<p>Sort:
			<select name="sort" id="sort">
				<option value="attemptID">Attempt ID</option>
				<option value="dateAndTime">Date And Time</option>
				<option value="firstName">First Name</option>
				<option value="lastName">Last Name</option>
				<option value="studentID">Student ID</option>
				<option value="attempts">Attempts</option>
				<option value="score">Score</option>
			</select>
		</p>
		<p>Order:
			<select name="order" id="order">
				<option value="ASC">Ascending </option>
				<option value="DESC">Descending</option>
			</select>
		</p>
		<p>
			<input type="submit" value="Generate" />
			<a href="../supervisor.html" id="button">Back</a>
		</p>
		
	</fieldset>
</form>