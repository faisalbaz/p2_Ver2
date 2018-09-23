 <?php
             	   require ("db.php");
             		// Create connection
						$conn = new mysqli($HostName, $UserName, $Password, $DBName);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						$sql = "SELECT * FROM bpreadings ORDER BY date DESC LIMIT 21";
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
				
 <?php
             	   require ("db.php");
             		// Create connection
						$conn = new mysqli($HostName, $UserName, $Password, $DBName);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

                  $tablename = "bpreadings";
						$sql = "SELECT * FROM $tablename ORDER BY date DESC";
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
							echo "<tr><td colspan='6'>No results found</td></tr>";
						}
						$conn->close();
             	?>
<?php
  require ("db.php");
             		// Create connection
						$conn = new mysqli($HostName, $UserName, $Password, $DBName);
						// Check connection
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}
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
 
 
				
				