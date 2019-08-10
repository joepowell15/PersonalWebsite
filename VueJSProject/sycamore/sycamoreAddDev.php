<?php
//Check if serial entered is already found
$serial= formatInput(htmlspecialchars($_REQUEST["serialnum"]))	;
$rack=formatInput(htmlspecialchars($_REQUEST["rack"]))	;
$pos=formatInput(htmlspecialchars($_REQUEST["position"]))	;
$model=formatInput(htmlspecialchars($_REQUEST["model"]))	;
$manu=formatInput(htmlspecialchars($_REQUEST["manufacturer"]))	;
$owner=formatInput(htmlspecialchars($_REQUEST["owner"]))	;
$group=formatInput(htmlspecialchars($_REQUEST["group"]))	;
$unt=formatInput(htmlspecialchars($_REQUEST["unt"]))	;
$dName=formatInput(htmlspecialchars($_REQUEST["dName"]))	;
$dComm=formatInput(htmlspecialchars($_REQUEST["dComm"]))	;
$height=formatInput(htmlspecialchars($_REQUEST["height"]))	;
if(!(is_Numeric($pos)))
{
	echo "Position Incorrect Format";
	return ;

}
$servername = "localhost";
$username = "joe";
$password = "Earthvsusa1515";
$dbname = "DCIM";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn2 = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


$sql =$conn->prepare("INSERT INTO Devices (`Serial_Number`, `UNT_Tracking_Number`, `U_Height`, `Manufacturer`,`Model`, `Device_Name`, `Owner`, `Grp`, `Comment`) VALUES (?,?,?,?,?,?,?,?)");	
$sql->bind_param("ssisssss",$serial,$unt,$height,$manu,$model,$dName,$owner,$group,$dComm);

$sql->execute();

if ($sql->affected_rows>0) {
	$inserted=true;
	
	
} else {
	$inserted=false;
	
}
$conn->close();

$sql =$conn2->prepare("INSERT INTO SycamoreDeviceInRack (`Location`, `Serial_Number`, `Position`) VALUES (?,?,?)");	
$sql->bind_param("ssi",$rack,$serial,$pos);

$sql->execute();

if ($sql->affected_rows>0) {
	$inserted2=true;
	
	
} else {
	$inserted2=false;

}
$conn2->close();

function formatInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
?>
<!DOCTYPE html>
<html>
<head>
<body>
<?php
if($inserted && $inserted2)
{
echo "<script>alert(\"Device Added Succesfully\")</script>";
echo"<script>window.location.assign(\"/VueJSProject/sycamore/add.php?\")</script>";
}
else {

	echo"<script>window.location.assign(\"/VueJSProject/sycamore/add.php?message=Bad\")</script>";
}

?>
</body>
</html>