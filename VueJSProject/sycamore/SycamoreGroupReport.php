	<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="/VueJSProject/Style.css">

<script>

        function populateForm() {

            if (window.XMLHttpRequest) {
                    
                   var xmlhttp = new XMLHttpRequest();
				   
                } 
				else {
                   var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
					
					//sets select options
					document.getElementById("Groups").innerHTML = "<option disabled=\"disabled\" selected=\"true\" value=\"\">Select a Group</option>";
					document.getElementById("Groups").innerHTML += this.responseText;
					}
                };
                xmlhttp.open("GET","getGroups.php", true);
                xmlhttp.send();             
            
		}
			
				
        
        
</script>
    <meta charset="utf-8" />
    <title>GAB560 Sorted by Group</title>
</head>
<body onload="populateForm();">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" >Reports</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item ">
       <a class="nav-link" href="index.php">Gab560 Home <span class="sr-only">(current)</span></a>
      </li>
	   <li class="nav-item">
        <a class="nav-link" href="Discovery.php">Discovery Park Home</a>
      </li>
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
      <li class="nav-item dropdown active">
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
	<a class="nav-link" href="/VueJSProject/archive.php">View Archives</a>
    
  </div>
</nav>

<h1 class="title">All Sycamore Devices By Group</h1>



<div id="groupInfo">
	<form class="ddMenu">
	<select id="Groups" v-model="selected" v-on:change="getInfo">
	<!-- form is populated from database on page load -->

	</select>
	</form>
	<br>
	<h1 class="text-light">Group: {{selected}}</h1>
	<br>
	<p id="info"><!-- Text here is added by Vuejs and the onchange function --><p>
	</div>





<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vue@2.6.6/dist/vue.min.js"></script>
<script src="groupReport.js"></script>

</body>
</html>