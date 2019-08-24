<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="/VueJSProject/Style.css">

    <meta charset="utf-8" />
    <title>Archive</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" >Reports</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/index.php">Gab560 Home </span></a>
      </li>
	   <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/discoPark/Discovery.php">Discovery Park Home</a>
      </li>
	    <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/sycamore/Sycamore.php">Sycamore Home</a>
      </li>
	 
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="rackDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Devices Sorted by Rack W/ Power
        </a>
        <div class="dropdown-menu" aria-labelledby="rackDropdown">
          <a class="dropdown-item" href="/VueJSProject/gab560/GABRackReport.php">GAB Devices</a>
          <a class="dropdown-item" href="/VueJSProject/discoPark/DiscoRackReport.php">Discovery Park Devices</a>
       <a class="dropdown-item" href="/VueJSProject/sycamore/SycamoreRackReport.php">Sycamore Devices</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="grpDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Devices Sorted by Group
        </a>
        <div class="dropdown-menu" aria-labelledby="grpDropdown">
          <a class="dropdown-item" href="/VueJSProject/gab560/GABGroupReport.php">GAB Devices</a>
          <a class="dropdown-item" href="/VueJSProject/discoPark/DiscoGroupReport.php">Discovery Park Devices</a>
       <a class="dropdown-item" href="/VueJSProject/sycamore/SycamoreGroupReport.php">Sycamore Devices</a>
        </div>
      </li>
	<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="addDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Add Devices
        </a>
        <div class="dropdown-menu" aria-labelledby="addDropdown">
          <a class="dropdown-item" href="/VueJSProject/gab560/add.php">Add To GAB Devices</a>
          <a class="dropdown-item" href="/VueJSProject/discoPark/add.php">Add To Discovery Park Devices</a>
          <a class="dropdown-item" href="/VueJSProject/sycamore/add.php">Add To Sycamore Devices</a>
        </div>
		 </ul>
	<a class="nav-link active">View Archives</a>
    
  </div>
</nav>

<h1 class="title">Device Archive </h1>

<input type="text" id="search" placeholder="Search Fields Below">
<?php
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

$sql = "SELECT * FROM `GAB560Archive` order by Date_Archived";	
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
	echo "<div class=\"table-responsive\">";
    echo "<table id=\"mytable\" class=\"table table-hover table-bordered table-dark table-striped \"><thead class=\"thead-light	\"><tr><th>Serial Number</th><th>Date Archived</th><th>Model</th><th>Manufacturer</th><th>Group</th><th>Description</th><th>U Height</th><th>Archived From</th></tr></thead><tbody>";
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["Serial_Number"]."</td><td>".$row["Date_Archived"]."<td>".$row["Model"]."</td><td>".$row["Manufacturer"]."</td><td>".$row["Grp"]."</td><td>".$row["Description"]."</td><td>".$row["U_Height"]."</td><td>".$row["Archived_From"]."</td></tr>";
		
	}
    echo "</tbody></table>";
	echo "</div>";
	
} else {
    echo "0 results";
}
$conn->close();
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="/VueJSProject/Javascript/filter.js"></script>
<script>
//drop down filter call
$('#mytable').ddTableFilter();
</script>
<script>
//table search 
var $rows = $('#mytable tr');
$('#search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
</script>
</body>
</html>