<?php
require('config.php');
    session_start();

$action = htmlspecialchars($_GET["action"]);
if(!$action) return;

if($action=="getQuote"){
	$query = 'Select * From Quotes Order By Rand() Limit 1';

	$result=mysqli_query($conn,$query);
	$quotes=mysqli_fetch_all($result,MYSQLI_ASSOC);
	echo json_encode($quotes);

}
else if ($action=="sessionCheck")
{
    echo $_SESSION["id"];
    return;
}
else if ($action=="addWeight")
{
    $date= htmlspecialchars($_GET["Date"]);
    $weight=htmlspecialchars($_GET["Weight"]);

    if(!$date){
        if(!$stmt = $conn->prepare("INSERT INTO Weights VALUES (?, ?, CURRENT_TIMESTAMP(),null)")){
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            return -1;
        };

        if(!$stmt->bind_param('id', $_SESSION["id"], $weight)){
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return -1;
        }
    }
    else
    {
    	if(!$stmt = $conn->prepare("INSERT INTO Weights VALUES (?, ?, ?,null)")){
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            return -1;
        };

        if(!$stmt->bind_param('ids', $_SESSION["id"], $weight,$date)){
            echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
            return -1;
        }
    }

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }
    else
    {
        echo 0;
    }
}
else if ($action=="endSesssion")
{
    session_unset();
    echo session_destroy();
    return;
}
else if ($action=="getWeight") {

	if(!$stmt = $conn->prepare("Select PersonId,AVG(Weight) as Weight,Date From Weights WHERE PersonId=? GROUP BY Date , PersonId Order By Date asc")){
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return -1;
    };

    if(!$stmt->bind_param('d', $_SESSION["id"])){
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }
    else
    {
        $result=$stmt->get_result();
        $response=mysqli_fetch_all($result,MYSQLI_ASSOC);
        echo json_encode($response);
    }
}
else if ($action=="register")
{
    $username=htmlspecialchars($_GET["Username"]);
    $password=htmlspecialchars($_GET["Password"]);
    $name=htmlspecialchars($_GET["Name"]);
    $age=htmlspecialchars($_GET["Age"]);
    $weight=htmlspecialchars($_GET["Weight"]);

    if(!$stmt = $conn->prepare("INSERT INTO Person VALUES (null, ?, ?, ?, ?, ?)")){
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return -1;
    };

    if(!$stmt->bind_param('sddss', $name, $age, $weight,$username, password_hash($password,PASSWORD_DEFAULT))){
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }
    else
    {
        $loginDetails['username']=$username;
        $loginDetails['password']=$password;
        echo json_encode($loginDetails);
    }
}
else if ($action=="login")
{
    $username=htmlspecialchars($_GET["Username"]);
    $password=htmlspecialchars($_GET["Password"]);
    $stmt = $conn->prepare("Select * FROM Person WHERE Username = ?");

    if(!$stmt){
        echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
        return -1;
    };

    if(!$stmt->bind_param('s',$username)){
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }

    if(!$stmt->execute()){
        echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        return -1;
    }
    else
    {
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if (password_verify($password,$row["Password"]))
        {
            $_SESSION["id"] = $row["PersonId"];
            echo $row["PersonId"];
        }
        else
        {
        	echo 0;
        }
    }
}

mysqli_free_result($result);
mysqli_close($conn);
?>