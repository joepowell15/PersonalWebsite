<?php
//Check if serial entered is already found
$serial = $_REQUEST["serial"];;
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

$sql = "DELETE FROM `GAB560DeviceInRack` Where Serial_Number = '".$serial."'";	
$result = $conn->query($sql);

if ($conn->query($sql) === TRUE) {
	  echo "Moved";
	
} else {
	 echo "Error deleting record: " . $conn->error;
}
$conn->close();
?>