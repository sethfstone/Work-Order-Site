<?php

//insert fontawesome link 
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />';

//insert bootstrap stuff
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';


//connect w db
include_once "../dbi.php";



// Set ordering for list of computers
if(isset($_GET['search_order'])){
	switch($_GET['search_order']){
		case 'end_user':
		case 'completed_date':
		case 'due_date':
		case 'created_date':
		case 'inv_item_type':
		case 'model_info':
		case 'barcode':
		case 'id':
			$orderOpt = filter_var($_GET['search_order'], FILTER_SANITIZE_URL);
	}
}else {
	$orderOpt = "id";
}




//Get relavent info/computers list
$gatherDataQuery = "SELECT id, completed_date, created_date, due_date, inv_item_type, model_info, end_user, barcode FROM new_computer_checklist where archived = 0 ORDER by $orderOpt";
$results = pg_query($dbh, $gatherDataQuery);
if(!isset($results)){die("Didnt grab information properly");}




//styling related stuff
echo '
        <style>
                #inner:hover{
                        background-color:lightgrey;
                        color: black;
                }

		#archive{
			background-color:red;
		}
	</style>

';



//Some js for navigation
echo '
	<script>
		document.addEventListener("keypress", function (e) {
   			 if (e.key === "Enter") {
      
				window.location.href = "https://aries.msussrc.com/apps/workorder";
			    }
		});


		function archive(ident){
			var item = document.getElementsByClassName(ident);
			item[0].click();
			
		}
	</script>
';




//table title
echo '
	<p style="font-size: 18px; font-weight: 500; position: relative; left: 27px; margin-top: 9px;">Current Orders: Incomplete and Complete</p>

';




//display general info here about history
echo '

<table class="table table-striped table-dark">
	<thead>
		<tr>
			<td><a href="https://aries.msussrc.com/apps/workorder/" style="text-decoration:none;color:#afdceb;display:inline-block;"><i>Home</i></a></td>
    			<td><a href="?search_order=id" style="text-decoration:none;color:#afdceb">ID</a></td>
			<td><a href="?search_order=completed_date" style="text-decoration:none;color:#afdceb">Completed Date</a></td>
    			<td><a href="?search_order=created_date" style="text-decoration:none;color:#afdceb">Created Date</a></td>
   			<td><a href="?search_order=due_date" style="text-decoration:none;color:#afdceb">Due Date</a></td>
    			<td><a href="?search_order=inv_item_type" style="text-decoration:none;color:#afdceb">Item Type</a></td>
			<td><a href="?search_order=model_info" style="text-decoration:none;color:#afdceb">Model Info</a></td>
    			<td><a href="?search_order=end_user" style="text-decoration:none;color:#afdceb">End User</a></td>
			<td><a href="?search_order=barcode" style="text-decoration:none;color:#afdceb">Barcode</a></td>
			<td><i style="color:#ce6262;">Archive</i></td>
		</tr>
	</thead>
	
';

while ($record = pg_fetch_array($results)){
	$ID = $record['id'];
	$completed_date = $record['completed_date'];
	$created_date = $record['created_date'];
	$due_date = $record['due_date'];
	$inv_item_type = $record['inv_item_type'];
	$model_info = $record['model_info'];
	$end_user = $record['end_user'];
	$barcode = $record['barcode'];


	echo "<tr id=inner>";
	echo"<td></td>";
	echo '<td><form action="../displayPHP/orderDetails.php" method="post"><input type="submit" value="'.$ID.'" name="submit" style="text-align:center;left:5%;width:100%;position:relative;background-color:#afdceb;border-style:none;border-radius:4px;margin-top:12px;left:-9px;"></form></td>';
	echo "<td>$completed_date</td>";
	echo "<td>$created_date</td>";
	echo "<td>$due_date</td>";
	echo "<td>$inv_item_type</td>";
	echo "<td>$model_info</td>";
	echo "<td>$end_user</td>";
	echo "<td>$barcode</td>";
	echo '<td><form action="../processingPHP/archive.php" method="post"><i class="fas fa-archive fa-2x1" style="position:relative; left:18px;top:9px;font-size:1.4em" id="'.$ID.'" onclick="archive(this.id)"></i><input type="submit" id="submit" name="submit" value="'.$ID.'" class="'.$ID.'" style="position:relative;left:500px;"></form></td>';
	echo "</tr>";
}

echo "</table>";



?>
