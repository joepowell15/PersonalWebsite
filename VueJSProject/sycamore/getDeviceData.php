<?php
//Check if serial entered is already found
$serial=  formatInput(htmlspecialchars($_REQUEST["serial"]))	;
$servername = "localhost";
$username = "joe";
$password = "Earthvsusa1515";
$dbname = "DCIM";
$responses=array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM `SycamoreDeviceInRack` as rck JOIN SycamoreDevices as dev on dev.Serial_Number=rck.Serial_Number and rck.Serial_Number='".$serial."'";	
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
			array_push($responses,$row['Serial_Number'],$row["Location"],$row['Position']);
			array_push($responses,$row['Model'],$row["Manufacturer"],$row['Grp'],$row['Owner']);

			
	
	
	}
	echo json_encode($responses);
 
	
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