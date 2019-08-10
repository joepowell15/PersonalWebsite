<?php

$servername = "localhost";
$username = "joe";
$password = "Earthvsusa1515";
$dbname = "DCIM";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//selects only unique groups to fill form
$sql = "SELECT Distinct Grp FROM `DiscoDevices` order by Grp";	
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	
	//return list of unique groups to javascript 
    while($row = $result->fetch_assoc()) {
       echo "<option value=". $row['Grp'] .">". $row['Grp'] . "</option>";
	  
		
	}

	
} else {
    echo "0 results";
}
$conn->close();



?>