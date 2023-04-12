<?php
// connect again w db
include_once "../dbi.php";


// Set ordering for wordorder / computer list
if(isset($_GET['search_order'])){
	switch($_GET['search_order']){
		case 'end_user':
		case 'due_date':
		case 'created_date':
		case 'assigned_to':
		case 'barcode':
		case 'id':
			$orderOpt = filter_var($_GET['search_order'], FILTER_SANITIZE_URL);
	}
}else {
	$orderOpt = "id";
}




// styling related stuff
echo '
	<style>
		#inner:hover{
			background-color:lightgrey;
			color: black;
		}


	</style>
';





//Gather required info for displaying current computers/workroders
$gatherDataQuery = "SELECT id, created_date, due_date, assigned_to, end_user, barcode FROM new_computer_checklist WHERE completed_date is null and archived = 0 ORDER by $orderOpt";
$results = pg_query($dbh, $gatherDataQuery);
if(!isset($results)){die("Didnt grab information");}




// form to send selected id to detailed information page (for displaying info) about computer selected
echo '<form action="displayPHP/orderDetails.php" method="post">';





//display general info here about all incomplete
echo <<< EOL

	<!-- table header info -->
	<table class="table table-striped table-dark" style="width:75%; position:relative; left: 12.5%;border-bottom-left-radius:12px; border-bottom-right-radius:12px">
		<thead>
			<tr>
    				<th><a href="?search_order=id" style="text-decoration:none;color:#afdceb; font-weight: 400">ID</a></th>
    				<th><a href="?search_order=created_date" style="text-decoration:none;color:#afdceb;font-weight: 400">Created Date</a></th>
   				<th><a href="?search_order=due_date" style="text-decoration:none;color:#afdceb;font-weight: 400">Due Date</a></th>
    				<th><a href="?search_order=assigned_to" style="text-decoration:none;color:#afdceb;font-weight: 400">Assigned To</a></th>
    				<th><a href="?search_order=end_user" style="text-decoration:none;color:#afdceb;font-weight: 400">End User</a></th>
				<th><a href="?search_order=barcode" style="text-decoration:none;color:#afdceb;font-weight: 400">Barcode</a></th>
			</tr> 
		</thead>
EOL;



//actually loop for displaying items here

while ($record = pg_fetch_array($results)){
	$ID = $record['id'];
	$created_date = $record['created_date'];
	$due_date = $record['due_date'];
	$assigned_to = $record['assigned_to'];
	$end_user = $record['end_user'];
	$barcode = $record['barcode'];


	echo "<tr id=inner>";
	echo "<td><input id=iden type='submit' name='selected' value='$ID' style='width:100%;background-color:#add8e6; border-radius: 5px;border-style:none'></input></td>";
	echo "<td>$created_date</td>";
	echo "<td>$due_date</td>";
	echo "<td>$assigned_to</td>";
	echo "<td>$end_user</td>";
	echo "<td>$barcode</td>";
	echo "</tr>";
}



echo "</table></form>";



?>
