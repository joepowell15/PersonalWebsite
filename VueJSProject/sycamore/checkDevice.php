<?php
//Check if serial entered is already found
$serial=  formatInput(htmlspecialchars($_REQUEST["serial"]))	;
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

$sql = "SELECT `Serial_Number` FROM `SycamoreDevices` Where Serial_Number = '".$serial."'";	
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	echo "$serial";
	
} else {
	echo "";
}
$conn->close();
function formatInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
?>