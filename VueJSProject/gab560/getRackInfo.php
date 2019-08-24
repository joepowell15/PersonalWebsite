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
$sql = "SELECT * FROM `GAB560Racks` WHERE Location='".$rack."'";
$sql2 = "SELECT * FROM `GAB560DeviceInRack` as rck JOIN GAB560Devices as dev on rck.Serial_Number=dev.Serial_Number AND rck.Location='".$rack."'";

$result = $conn->query($sql2);
$result2 = $conn->query($sql);
if ($result->num_rows > 0) {
	
	$rackInfo = $result2->fetch_assoc();
	echo "<h3>Power Configuration</h3></br>";
	echo "<div class=\"table-responsive\">";
    echo "<table id=\"rackPower\" class=\"table table-hover table-bordered table-dark table-striped \"><thead class=\"thead-light	\"><tr><th style=\"display:none;\">Location</th><th>Model</th><th>Subfloor Power</th><th>Power North</th><th>Power South</th><th>Phase</th><th>AVolts</th><th>AAmps</th></thead><tbody>";
    // output data of each row
        echo "<tr><td style=\"display:none;\">".$rackInfo["Location"]."</td><td>".$rackInfo["Model"]."</td><td>".$rackInfo["SubFloor_Power"]."<td>".$rackInfo["Power_North"]."</td><td>".$rackInfo["Power_South"]."</td><td>".$rackInfo["Phase"]."</td><td>".$rackInfo["AVolt"]."</td><td>".$rackInfo["AAmps"]."</td></tr>";
		
	 
    echo "</tbody></table><div><input class=\"btn btn-info\" onclick=\"edit()\" type=\"button\" value=\"Edit Rack\"/></div></br>";
	echo "</div>";
	echo "<h3>Devices In Rack</h3></br>";
	echo "<div class=\"table-responsive\">";
    echo "<table id=\"rackPower\" class=\"table table-hover table-bordered table-dark table-striped \"><thead class=\"thead-light	\"><tr><th>Serial Number</th><th>UNT Tracking Number</th><th>U Height</th><th>Manufacturer</th><th>Model</th><th>Rack</th><th>Position</th><th>Owner</th><th>Group</th></tr></thead><tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Serial_Number"]."</td><td>".$row["UNT_Tracking_Number"]."<td>".$row["U_Height"]."</td><td>".$row["Manufacturer"]."</td><td>".$row["Model"]."</td><td>".$row["Location"]."</td><td>".$row["Position"]."</td><td>".$row["Owner"]."</td><td>".$row["Grp"]."</td></tr>";
		
	}
    echo "</tbody></table>";
	echo "</div>";
	
} else {
    echo "0 results";
}
$conn->close();



?>
