<?php
//get all device info about the rack requested
$rack = $_REQUEST["rack"];
$servername = "localhost";
$username = "joe";
$password = "";
$dbname = "DCIM";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//get all device info about the rack requested
$sql = "SELECT * FROM `DiscoDeviceInRack` as rck JOIN DiscoDevices as dev on rck.Serial_Number=dev.Serial_Number AND rck.Location='".$rack."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
	echo "<div class=\"table-responsive\">";
    echo "<table id=\"mytable\" class=\"table table-hover table-bordered table-dark table-striped \"><thead class=\"thead-light	\"><tr><th>Serial Number</th><th>UNT Tracking Number</th><th>U Height</th><th>Model</th><th>Manufacturer</th><th>Rack</th><th>Position</th><th>Owner</th><th>Group</th></tr></thead><tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Serial_Number"]."</td><td>".$row["UNT_Tracking_Number"]."<td>".$row["U_Height"]."</td><td>".$row["Model"]."</td><td>".$row["Manufacturer"]."</td><td>".$row["Location"]."</td><td>".$row["Position"]."</td><td>".$row["Owner"]."</td><td>".$row["Grp"]."</td></tr>";
		
	}
    echo "</tbody></table>";
	echo "</div>";
	
} else {
    echo "0 results";
}
$conn->close();



?>