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
      <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/index.php">Gab560 Home <span class="sr-only">(current)</span></a>
      </li>
	   <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/discoPark/Discovery.php">Discovery Park Home</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="/VueJSProject/sycamore/Sycamore.php">Sycamore Home</a>
      </li>
	 
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="rackDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Devices Sorted by Rack W/ Power
        </a>
        <div class="dropdown-menu " aria-labelledby="rackDropdown">
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

<h1 class="title">Update Rack Information</h1>
<form class="input">
  <div class="form-group" id="formapp">
  
    <label for="input1">Location</label>
    <input v-model="location" type="text" readonly class="form-control-plaintext text-light" name="location">
  
  <br>
	<label for="input2">U Height</label>
    <input v-model="height" v-on:blur="validHeight" type="text" class="form-control" name="rack" placeholder="Enter Rack's Height" required>
    <p class="text-danger error">{{errorHeight}}</p>
	<br>
	<label for="input3">Model</label>
    <input  v-model="model"  type="text" class="form-control" name="model" placeholder="Enter Rack's Model" required>
   
	<label for="input4">Subfloor Power </label>
    <input  v-model="power"  type="text" class="form-control" name="subfloor" placeholder="Enter Rack's North/South Power" required>
    
	<label for="input5">North Breakers</label>
    <input  v-model="north"  type="text" class="form-control" name="north" placeholder="Enter North Breakers">
   
   <label for="input6">South Breakers </label>
    <input  v-model="south"  type="text" class="form-control" name="south" placeholder="Enter South Breakers">
       
   <label for="input7">Phase </label>
    <input  v-model="phase"  type="text" class="form-control" name="phase" placeholder="Enter Rack's Phase">
   
   <label for="input8">Avolts</label>
    <input  v-model="avolts" v-on:blur="validVolt"  type="text" class="form-control" name="volts" placeholder="Enter Voltage">
       <p class="text-danger error">{{errorVolt}}</p>
   <br>
   <label for="input9">AAmps </label>
    <input  v-model="aamps" v-on:blur="validAmp" type="text" class="form-control" name="aamps" placeholder="Enter Amperage">
	<p class="text-danger error">{{errorAmps}}</p>
   <br>
	
     <button class="btn btn-primary" v-on:click="update" :disabled=isDisabled id="submit" type="button">Update Rack</button>
	 
  </div>
  </form>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/vue@2.6.6/dist/vue.min.js"></script>
 <script src="/VueJSProject/gab560/powerVue.js"></script>	


</body>
</html>