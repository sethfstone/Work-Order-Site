<?php

//connect page to db
include_once '../dbi.php';


//fontawesome / bootstrap links
echo '
	<head>
		<!-- Bootstrap stuff -->
                   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
                   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
                   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
                   <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

		<!-- Font Awesome stuff -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	</head>
';

echo '<body>';


// some functional definitions and styling stuff
echo '
	<script>
		function search(){
			var button = document.getElementsByName("submitSearch");
			button[0].click();
		}

		function display(){
			var input = document.getElementById("test");
			input.style.display = "inline-block";
		}
	</script>


	<style>
		input[type=search]:focus{
			border-color: #add8e6;
			box-shadow: 0 0 6px #add8e6;
		}

		input[type=text]:focus{
			box-shadow: 0 0 6px #c3b1e1;
			border-color:#e6e6fa;
		}

		.dropdown-item:hover{
			background-color:#ecfbff;
		}
		
		#searchParams{
			background-color:white;
			color:#808080;
			border-color:lightgrey;
			
		}

		#searchParams:focus{
			border-color: #add8e6;
			box-shadow: 0 0 6px #add8e6;
		}

		#menuItem:hover{
			background-color:#ecfbff;
			border-radius:9px;
			color: black;
		}

		#menuItem {
			background-color: 32383e;
			color: white;
			border-color:grey;
			border-style:solid;
			border-width: 1px;
			border-radius: 6px;
			margin-top:3px; margin-left: 3px;
		}

		#createdByInfo:hover {
			background-color:#ecfbff;	
			color: black;
		}
	
		#completedByInfo:hover {
			background-color:#ecfbff;
			color:black;
			color: black;
		}

		#createdDateInfo:hover{
			background-color:#e6e6fa;
			color: black;
		}
	
		#completedDateInfo:hover{
			background-color:#e6e6fa;
			color: black;
		}

		#assignedToInfo:hover{
			background-color:#e6e6fa;
			color: black;
		}

		#itemTypeInfo:hover{
			background-color:#ecfbff;
			color: black;
		}

		#modelDetailsInfo:hover{
			background-color:#e6e6fa;
			color: black;
		}

		#endUserInfo:hover{
			background-color:#ecfbff;
			color:black;
		}
		
		#archivedInfo:hover{
			background-color:#e6e6fa;
			color: black;
		}

		#back {
			text-decoration: none;
		}

	</style>
';





$self = pg_escape_string($_SERVER['PHP_SELF']);
echo '
	<a href="../" id="back" style="position:relative; top: 39px; left: 20%;">Home</a>
';



// grab information on which parameters are used to build search
echo '
	<div>
	<form action="'.$self.'" method="post">
	        <input type="submit" name="submitSearch" style="display:none;" value="submit">
		<div style="position:relative; width: 40%; left:30%; background-color:lightgrey; height: fit-content">
			<div style="float:left;position:relative; width: 50%;  height: fit-content">
				<div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="createdBy" name="createdBy" id="createdBy"></input><label style="margin-left:9px; margin-top:3px; padding-right: 40px;  " for="createdBy" >Created By</label></div>
                        	<div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="createdDate" name="createdDate" id="createdDate"></input><label style="margin-left:9px; margin-top:3px; padding-right: 40px;" for="createdDate">Created Date</label></div>
                        	<div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="completedBy" name="completedBy" id="completedBy"></input><label style="margin-left:9px; margin-top:3px; padding-right:40px;" for="completedBy">Completed By</label></div>
                        	<div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="completedDate" name="completedDate" id="completedDate"></input><label style="margin-left:9px; margin-top:3px; padding-right: 30px;" for="completedDate">Completed Date</label></div>
			</div>
			<div style="float:right;position:relative; width: 50%;  height: fit-content">
				<div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="itemType" name="itemType" id="itemType"></input><label style="margin-left:9px; margin-top:3px; padding-right: 10px;" for="itemType">Inventory Item Type</label></div>
                                <div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="modelInfo" name="modelInfo" id="modelInfo"></input><label style="margin-left:9px; margin-top:3px; padding-right: 40px;" for="modelInfo">Model Info</label></div>
                                <div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="endUser" name="endUser" id="endUser"></input><label style="margin-left:9px; margin-top:3px; padding-right: 40px;" for="endUser">End User</label></div>
                                <div id="menuItem"><input style="margin-left: 9px; margin-top:3px;" type="checkbox" value="barcode" name="barcode" id="barcode"></input><label style="margin-left:9px; margin-top:3px; padding-right: 40px;" for="barcode">Barcode</label></div>
			</div>
		</div>
	</form>
	</div>
';






//gather input for custom query (not fully implemented for security reasons)
echo '
	<div>
		<form action="../displayPHP/displaySearch.php" method="post">
			<div style="width:40%; left:30%; position:absolute;  top: 210px; margin-left: 2px;">
 				 <input type="text" id="form1" class="form-control" placeholder="Type custom query" aria-label="Search" />
			</div>
		</form>
	</div>
';







echo'
<div class="table-logic" style="height:fit-content;position:absolute;left: 20%; width:60%;border-radius:6px;overflow:hidden; top:270px;">
	<div>
';


// Search param table displayed here
echo '
<form action="../displayPHP/displaySearch.php" method="post">
<table class="table table-hover table-dark">
	<thead>
		<tr><th scope="col" style="text-align:center;color:#36454f">Search Parameters</th></tr>
	</thead>
	<tbody>	
	<tr>
	<td>
	<div>
		<label>Archive Info</label>
		<label style="margin-left: 27px;">Current:</label> 
                <input type="radio" name="archiveInfo" value="current">
		<label style="margin-left: 27px;">Archived:</label>
		<input type="radio" name="archiveInfo" value="archived">
		<label style="margin-left: 27px;">All:</label>
		<input type="radio" name="archiveInfo" value="all" checked>
	</div>
	</td>
	</tr>
	<tr>

	<!--header info here -->
';

//processes search query paramter inputs 
	if(isset($_POST['createdDate'])){
		$createdDate = htmlspecialchars($_POST['createdDate']);
		echo '
			<tr id="createdDateInfo" >
			<td >
				<div style="display:flex">
					<div>
						<label style="margin-right: 9px">Created Date</label>
						<input type="date" name="createdDate" placeholder="Created Date" style="border-radius: 6px;border-color:grey;border-style:solid;border-width:1px;padding: 2x">
					</div>
					<div style="margin-left: 9px">
						<label style="margin-left:9px">On/before:</label>
						<input type="radio" name="radio" value="before">
						<label style="margin-left:9px">On/after:</label>
						<input type="radio" name="radio" value="after">
						<label style="margin-left:9px">On:</label>
						<input type="radio" name="radio" value="on">
					</div>
				</div>
			</td>
			</tr>
		';
	}

	if(isset($_POST['createdBy'])){
		$createdBy = htmlspecialchars($_POST['createdBy']);
		echo '
			<tr id="createdByInfo">
			<td>
				<div style="display:flex">
					<label>Created By</label>
					<input type="text" name="createdBy" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
				</div>
			</td>
			</tr>
		';
	}
	
	if(isset($_POST['completedDate'])){
		$completedDate = htmlspecialchars($_POST['completedDate']);
		echo '
			<tr id="completedDateInfo">
			<td>
				<div style="display:flex">
                                        <div>
                                                <label style="margin-right: 9px">Completed Date</label>
                                                <input type="date" name="completedDate" placeholder="Completed Date" style="border-radius: 6px;border-color:grey;border-style:solid;border-width:1px;padding: 2x">
                                        </div>
                                        <div style="margin-left:9px; justify-content: space-around">
						<label style="margin-left:9px">On/before:</label>
                                                <input type="radio" name="radio2" value="before">
						<label style="margin-left:9px">On/after:</label>
                                                <input type="radio" name="radio2" value="after">
						<label style="margin-left:9px">On:</label>
                                                <input type="radio" name="radio2" value="on">
                                        </div>
                                </div>
			</td>
			</tr>
		';
	}

	if(isset($_POST['completedBy'])){
		$createdBy = htmlspecialchars($_POST['completedBy']);
                echo '
                        <tr id="completedByInfo">
                        <td>
                                <div style="display:flex">
                                        <label>Completed By</label>
                                        <input type="text" name="completedBy" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';

	}

	if(isset($_POST['assignedTo'])){
		$assignedTech = htmlspecialchars($_POST['assignedTo']);
		echo '
                        <tr id="assignedToInfo">
                        <td>
                                <div style="display:flex">
                                        <label>Order Assigned To</label>
                                        <input type="text" name="assignedTo" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';
	}

	if(isset($_POST['itemType'])){
                $itemType = htmlspecialchars($_POST['itemType']);
                echo '
                        <tr id="itemTypeInfo">
                        <td>
                                <div style="display:flex">
                                        <label>Inventory Item Type</label>
                                        <input type="text" name="itemType" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';
        }

	if(isset($_POST['modelInfo'])){
                $modelInfo = htmlspecialchars($_POST['modelInfo']);
                echo '
                        <tr id="modelDetailsInfo">
                        <td>
                                <div style="display:flex">
                                        <label>Model Details</label>
                                        <input type="text" name="modelInfo" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';
        }

	if(isset($_POST['endUser'])){
                $endUser = htmlspecialchars($_POST['endUser']);
                echo '
                        <tr id="endUserInfo">
                        <td>
                                <div style="display:flex">
                                        <label>End User</label>
                                        <input type="text" name="endUser" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';
        }

	if(isset($_POST['barcode'])){
                $archived = htmlspecialchars($_POST['barcode']);
                echo '
                        <tr id="barcodeInfo">
                        <td>
                                <div style="display:flex">
                                        <label>Barcode</label>
                                        <input type="text" name="barcode" style="margin-left:27px; border-radius: 6px; border-style:solid; border-color: grey; border-width: 1px;">
                                </div>
                        </td>
                        </tr>
                ';
        }
echo '  </tr>';




echo'
		</table>

		<input type="submit" style="display:none">
	</form>
';




echo'</div></div></body>';

?>
