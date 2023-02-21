<?php

//connect page to db
include_once '../dbi.php';

//boostrap stuff
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';



// Set ordering for listing computers
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
$gatherDataQuery = "SELECT id, completed_date, created_date, due_date, inv_item_type, model_info, end_user, barcode FROM new_computer_checklist where archived = 1 ORDER by $orderOpt";
$results = pg_query($dbh, $gatherDataQuery) or die("Didnt get response from sql db");

//styling related stuff
echo '
        <style>
                #inner:hover{
                        background-color:lightgrey;
                        color: black;
                }

		.img-wrapper{
			display:inline-block;
			overflow:hidden;

			-webkit-filter: contrast(0) sepia(100%) hue-rotate(190deg) saturate(2000%) brightness(100%);
  			filter: contrast(0) sepia(50%) hue-rotate(333deg) saturate(2000%) brightness(100%);
  			opacity: 1;
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
	</script>
';


//Title of list
echo '
	<p style="font-size: 18px; font-weight: 500; position: relative; left: 27px; margin-top: 9px;">Archived Orders</p>

';

//begin form / table header
echo '<form action="orderDetails.php" method="post">

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
                	</tr>	
        	</thead>
';



//builds table displaying entries
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
        echo "<td><input type='submit' name='selected' value='$ID' style='height:27px;width:100%;background-color:#afdceb;border-radius: 5px;border-style:none'></input></td>";
        echo "<td>$completed_date</td>";
        echo "<td>$created_date</td>";
        echo "<td>$due_date</td>";
        echo "<td>$inv_item_type</td>";
        echo "<td>$model_info</td>";
        echo "<td>$end_user</td>";
        echo "<td>$barcode</td>";
        echo "</tr>";
}





echo '</table></form>';

?>
