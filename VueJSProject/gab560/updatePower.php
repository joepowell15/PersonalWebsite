<?php
$servername = "localhost";
$username = "joe";
$password = "Earthvsusa1515";
$dbname = "DCIM";
$mysqli = new mysqli($servername,$username,$password,$dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$location= formatInput(htmlspecialchars($_REQUEST["location"]));
$model=formatInput(htmlspecialchars($_REQUEST["model"]));
$height=formatInput(htmlspecialchars($_REQUEST["height"]));
$power=formatInput(htmlspecialchars($_REQUEST["power"]));
$north=formatInput(htmlspecialchars($_REQUEST["north"]));
$south=formatInput(htmlspecialchars($_REQUEST["south"]));
$phase=formatInput(htmlspecialchars($_REQUEST["phase"]));
$aamps=formatInput(htmlspecialchars($_REQUEST["aamps"]));
$avolts=formatInput(htmlspecialchars($_REQUEST["avolts"]));
if(!(is_Numeric($height)))
{
	echo "Height $height Incorrect Format";
	return;

}

if(!(is_Numeric($aamps)))
{
	echo "Amperage $aamps Incorrect Format";
	return;

	if(!(is_Numeric($avolts)))
{
	echo "Voltage $havolts Incorrect Format";
	return;

}



if ($stmt = $mysqli->prepare("Update GAB560Racks set U_Height=?,Model=?,SubFloor_Power=?,Power_North=?,Power_South=?,Phase=?,Avolt=?,AAmps=? WHERE Location=?")) {

    $stmt->bind_param("isssssiis",$height,$model,$power,$north,$south,$phase,$avolts,$aamps,$location);
	 //not true when no rows are updated
    if($stmt->execute() && $stmt->affected_rows==1)
	{
	echo "Good";
	$stmt->bind_result($result);

  
    $stmt->fetch();
	}
	else if($stmt->affected_rows>1) {
	//should never update one more than one row or things have gone horribly wrong
	$conn->rollback();
	echo "Rack name is present more than once. This should never happen";
}
else {
	echo "Error Executing Query";
}
    
    $stmt->close();
	$mysqli->close();
}




function formatInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
?>