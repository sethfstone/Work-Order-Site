<?php
//Site written for: LAMP web-stack 


	//Connect page to database
	include_once 'processingPHP/dbi.php';
	
	//main page header (includes links for fonts/bootstrap tables)
	echo '<html>



		<head>
		  <title>New Computer Checklist</title>
		  <meta charset="UTF-8">

		   <!--  font stuff   -->
		   <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

		   <!-- Bootstrap stuff -->
		   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		   <!-- JQuery stuff -->
		   <script src="https://ajax.googleapis.com/ajax/libs/cesiumjs/1.78/Build/Cesium/Cesium.js"></script>		

		   <!-- Font Awesome stuff -->
		   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		</head>


		<!-- Main body / refresh bug fix -->
		<body>
			<input type="hidden" id="refreshed" value="no">

			<script>
				function backButtonSetup(){
					window.addEventListener( "pageshow", function ( event ) {
  						var historyTraversal = event.persisted || ( typeof window.performance != "undefined" && window.performance.navigation.type === 2 );
  						if ( historyTraversal ) {
				    			// Handles page restore
    							window.location.reload();
  						}
					});
				}; 
			</script>



		<!-- Nav bar stuff -->
		<nav class="navbar navbar-expand-lg navbar-light bg-light" style="position:relative;left:12.5%;width:75%;">
  			<a class="navbar-brand" href="?search_order=id">Where would you like to go?</a>
  			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    				<span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    				<div class="navbar-nav">
      					<a class="nav-item nav-link active" href="?search_order=id">Home <span class="sr-only">(current)</span></a>
      					<a class="nav-item nav-link" href="displayPHP/newComputer.php">New Order</a>
      					<a class="nav-item nav-link" href="displayPHP/history.php">Order History</a>
					<a class="nav-item nav-link" href="displayPHP/archive.php">Archive</a>
					<a class="nav-item nav-link" href="displayPHP/search.php">Search</a>
    				</div>
  			</div>
		</nav>
		';



	//displays current workorders	
	include_once 'displayPHP/displayAll.php';


echo '</body></html>';

