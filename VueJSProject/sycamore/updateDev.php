<?php


$servername = "localhost";
$username = "joe";
$password = "Earthvsusa1515";
$dbname = "DCIM";
$mysqli = new mysqli($servername,$username,$password,$dbname);
$mysqli2 = new mysqli($servername,$username,$password,$dbname);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$serial=  formatInput(htmlspecialchars($_REQUEST["serial"]))	;
$rack= formatInput(htmlspecialchars($_REQUEST["rack"]))	;
$pos= formatInput(htmlspecialchars($_REQUEST["pos"]))	;
$model= formatInput(htmlspecialchars($_REQUEST["model"]))	;
$owner= formatInput(htmlspecialchars($_REQUEST["owner"]))	;
$group= formatInput(htmlspecialchars($_REQUEST["group"]))	;
$manu= formatInput(htmlspecialchars($_REQUEST["manu"]))	;
if(!(is_Numeric($pos)))
{
	echo "Position Incorrect Format";
	return ;

}
if ($stmt = $mysqli->prepare("Update SycamoreDeviceInRack set Location=?,Position=? WHERE Serial_Number=?")) {


    $stmt->bind_param("sis",$rack,$pos,$serial);

 
    if($stmt->execute() && $stmt->affected_rows==1)
	{
	echo "Good";
	$stmt->bind_result($result);

  
    $stmt->fetch();
	}
	elseif ($stmt->affected_rows>1) {
	$conn->rollback;
	echo "Bad";
}
	
	else{
		echo "Bad";
	}



  
    
    $stmt->close();
}
if ($stmt = $mysqli2->prepare("Update SycamoreDevices set Model=?,Manufacturer=?,Grp=?,Owner=? WHERE Serial_Number=?")) {


    $stmt->bind_param("sssss",$model,$manu,$group,$owner,$serial);

 
    if($stmt->execute() && $stmt->affected_rows==1)
	{
	echo "Good";
	$stmt->bind_result($resultTrig);

  
    $stmt->fetch();
	}

	elseif ($stmt->affected_rows>1) {
	$conn->rollback;
	echo "Too many Updated";
}
	
	else{
		echo "Statement not executed";
	}
   
    

  
    
    $stmt->close();
}

/* close connection */
$mysqli->close();


function formatInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}
?>