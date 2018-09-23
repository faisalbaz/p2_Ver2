<!DOCTYPE html>

<html lang="en">
<head>
   <title>Blood Pressure Monitor</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="myStyle.css">
   <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
   <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
&nbsp;<br>
<?php
   $msg = "";

   if (isset($_POST['submit'])) {

	   foreach($_POST as $key =>$value) {
			$$key=$value;
		}

		//convert date into MYSQL date
		$phpdate = strtotime($mydate);
		$mysqldate = date('Y-m-d', $phpdate);

		//convert time into MYSQL time
		$phptime = strtotime($mytime);
		$mysqltime = date('H:i:s', $phptime);

		require ("db.php");
		// Create connection
		$conn = mysqli_connect($HostName, $UserName, $Password, $DBName);
		// Check connection
		if (!$conn) {
			 die("Connection failed: " . mysqli_connect_error());
		}

		//values
		$rowid = "0";
		$clientid = "1";

		//escape variables for security
		$mysqldate = mysqli_real_escape_string($conn, $mysqldate);
		$mysqltime = mysqli_real_escape_string($conn, $mysqltime);
		$systolic = mysqli_real_escape_string($conn, $systolic);
		$diastolic = mysqli_real_escape_string($conn, $diastolic);
		$pulse = mysqli_real_escape_string($conn, $pulse);
		$notes = mysqli_real_escape_string($conn, $notes);

		$Tablename = "bpreadings";
		$sql = "INSERT INTO $Tablename (id, client, date, time, systolic, diastolic, pulse, notes) VALUES ('$rowid', '$clientid', '$mysqldate', '$mysqltime', '$systolic', '$diastolic', '$pulse', '$notes');";

		if (mysqli_query($conn, $sql)) {
			//$msg = "Your Blood Pressure data was entered into the database";
		} else {
			$msg = "Error: " . $sql . "<br>" . mysqli_error($conn);
		}

		mysqli_close($conn);
	}
?>
<div class="container">
	<div class="row">
	   <div class="col-sm-6">
	      <img src="images/BPLogo.jpg" class="img-responsive center-block" width="300" height="200" alt="BPLogo">
	   </div>

	</div>
   <div class="row" style="margin-top: 20px;">
	   <div class="col-sm-6" style="border: solid 1px #DDDDDD; margin-bottom: 20px;">
			<h2>Add New Blood Pressure Readings:</h2>
			<form action="index.php" method="post">
				<div class="form-group">
					<label for="mydate">Date:</label>
					<input type="date" class="form-control" id="mydate" name="mydate" required>
				</div>
				<div class="form-group">
					<label for="mytime">Time:</label>
					<input type="time" class="form-control" id="mytime" name="mytime" required>
				</div>
				<div class="form-group">
					<label for="systolic">systolic:</label>
					<input type="number" class="form-control" id="systolic" name="systolic" required>
				</div>
				<div class="form-group">
					<label for="diastolic">diastolic:</label>
					<input type="number" class="form-control" id="diastolic" name="diastolic" required>
				</div>
				<div class="form-group">
					<label for="pulse">Pulse:</label>
					<input type="number" class="form-control" id="pulse" name="pulse">
				</div>
				<div class="form-group">
					<label for="notes">Notes:</label>
					<textarea class="form-control" rows="2" id="notes" name="notes"></textarea>
				</div>
				<button type="submit" class="btn btn-primary" id="submit" name="submit">Submit</button>
			</form>
			<br><br>
			<img src="images/BPChart.jpg" class="img-responsive center-block" width="609" height="720" alt="blood pressure table">
			<br>&nbsp;
	   </div>
	   <div class="col-sm-6">
		   <h2 class="text-center" style="margin-top: 0px;">Your Blood Pressure History</h2><p style="text-align: center;">Last 20 Readings</p>
			<?php
			   echo "<p style='color: red; text-weight: bold;'>$msg</p>";
			?>
			<div class="table-responsive">
			   <table class="table table-bordered">
					<thead>
						<tr>
							<th>Date</th>
							<th style="width: 60px;">Time</th>
							<th>systolic</th>
							<th>diastolic</th>
							<th>Pulse</th>
							<th>Notes</th>
							
						</tr>
					</thead>
					<tbody>
               <?php
             	   require ("db.php");
             		// Create connection
						$conn = new mysqli($HostName, $UserName, $Password, $DBName);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						$sql = "SELECT * FROM bpreadings ORDER BY date DESC LIMIT 31";
						$result = $conn->query($sql);

						if ($result->num_rows > 0) {
							// output data of each row
							while($row = $result->fetch_assoc()) {
							   $myid = $row["id"];
								$clientid = $row["client"];
							   $mydate = $row["date"];
								$thisdate = strtotime($mydate);
                        $UserName = date("m/d/Y", $thisdate);
                        $mytime = $row["time"];
								$thistime = strtotime($mytime);
								$NewTime = date("g:i A", $thistime);
								$systolic = $row["systolic"];
								$diastolic = $row["diastolic"];
								$pulse = $row["pulse"];
								$notes = $row["notes"];
								if ($pulse == "0") {
								   $pulse = "n.a.";
								}
							   echo "<tr>";
								echo "<td>$UserName</td>";
								echo "<td>$NewTime</td>";
								echo "<td>$systolic</td>";
								echo "<td>$diastolic</td>";
								echo "<td>$pulse</td>";
								echo "<td>$notes</td>";
								
							}
						} else {
							echo "<tr><td colspan='6'>no results</td></tr>";
						}
						$conn->close();
             	?>
					</tbody>
				</table>
				
			</div>
	   </div>
	</div>
	<div class="row">
	   <div class="col-sm-12">
		  &nbsp;
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
