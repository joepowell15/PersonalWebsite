<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="/VueJSProject/Style.css">

    <meta charset="utf-8" />
    <title></title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" >Reports</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbar">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="/VueJSProject/index.php">Gab560 Home <span class="sr-only">(current)</span></a>
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
	<a class="nav-link" href="/VueJSProject/archive.php">View Archives</a>
    
  </div>
</nav>

<h1 class="title">Update or Move To Archive</h1>
<form class="input">
  <div class="form-group" id="formapp">
  
    <label for="input1">Serial Number </label>
    <input v-model="serial"  v-on:blur="validSerial" type="text" readonly class="form-control-plaintext text-light" name="serialnum" placeholder="Enter Serial Number" required>
  <p class="text-danger error">{{errorSerial}}</p>
  <br>
	<label for="input2">Rack</label>
    <input v-model="rack" v-on:blur="validRack" type="text" class="form-control" name="rack" placeholder="Enter Device's Rack" required>
    <p class="text-danger error">{{errorRack}}</p>
	<br>
	<label for="input3">Rack Position</label>
    <input  v-model="pos"  v-on:blur="validPos" type="text" class="form-control" name="position" placeholder="Enter Device's Position in Rack 1-45" required>
   <p class="text-danger error">{{errorPos}}</p>
   <br>
  	  <label for="input4">Model</label>
    <input type="text" v-model="model" class="form-control" name="model" placeholder="Enter Devices Model">
    <label for="input5">Manufacturer</label>
    <input type="text" v-model="manu" class="form-control" name="manufacturer" placeholder="Enter Device Manufacturer">
	 <label for="input6">Group</label>
    <input type="text" v-model="group" class="form-control" name="group" placeholder="Enter Device Group">
	 <label for="input7">Owner</label>
    <input type="text" v-model="owner" class="form-control" name="owner" placeholder="Enter Device Owner">
	<br>

   
     <button class="btn btn-primary" v-on:click="update" :disabled=isDisabled id="submit" type="button">Update Device</button>
	 <button class="btn btn-danger" v-on:click="move" :disabled=isDisabledSerial type="button">Move to Archive</button>
  </div>
  </form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/vue@2.6.6/dist/vue.min.js"></script>
 <script src="/VueJSProject/gab560/updateVue.js"></script>	


</body>
</html>