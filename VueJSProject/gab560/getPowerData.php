<?php
//Check if serial entered is already found
$rack = $_REQUEST["rack"];
$servername = "localhost";
$username = "joe";
$password = "";
$dbname = "DCIM";
$responses=array();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM `GAB560Racks` WHERE Location ='".$rack."'";	
$result = $conn->query($sql);


if ($result->num_rows > 0) {
while($row = $result->fetch_assoc()) {
			array_push($responses,$row['Location'],$row["Model"],$row['U_Height'],$row['SubFloor_Power']);
			array_push($responses,$row['Power_North'],$row["Power_South"],$row['Phase'],$row['AVolt'],$row['AAmps']);
		
	}
	echo json_encode($responses);
 
	
} else {
	echo "";
}
$conn->close();
?>