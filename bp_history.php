<!DOCTYPE html>

<html lang="en">
<head>
   <title>My Blood Pressure History</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="myStyle.css">
   <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
   <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>

<body>
&nbsp;<br>

<div class="container">
   <div class="row">
      <div class="col-sm-6">
         <a href="index.php"><img src="images/BPLogo.jpg" class="img-responsive center-block" width="162" height="148" alt="BPLogo"></a>
      </div>
    
   </div>
   <div class="row" style="margin-top: 20px;">
      <div class="col-sm-2">
		   &nbsp;
	   </div>
	   <div class="col-sm-8" style="border: solid 1px #DDDDDD; margin-bottom: 20px;">
			<h2>My Blood Pressure History:</h2>
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

                  $tablename = "bpdata";
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
					</tbody>
				</table>
			</div>
	   </div>
	   <div class="col-sm-2">
		   &nbsp;
	   </div>
	</div>
   </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
