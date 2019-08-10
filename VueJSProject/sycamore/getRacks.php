<?php
//Get a list of all racks in the rack table
$serial=  formatInput(htmlspecialchars($_REQUEST["serial"]));
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

$sql = "SELECT Location FROM `SycamoreRacks` order by Location";	
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	
	
    while($row = $result->fetch_assoc()) {
       echo "<option value=". $row['Location'] .">". $row['Location'] . "</option>";
	   
		
	}

	
} else {
    echo "0 results";
}
$conn->close();


function formatInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
?>