<?php
//connect page to db 
include_once '../dbi.php';



//bootstrap stuff
echo '<head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"></head>';




//function used to validate date inputs
function valiDate($crDate, $comDate){
	if($crDate > $comDate){ 
		die("Conflicting input dates");
	} 
}






//building query logic here (for searching for a workorder)
$gatherSearchResQuery = "select (created_date, created_by, id, barcode, completed_date, completed_by, assigned_to, inv_item_type, from_room, to_room, due_date, model_info, end_user, archived) from new_computer_checklist where 1 = 1";




//gathers information for building search query
if(isset($_POST['archiveInfo']) and $_POST['archiveInfo'] != ""){
	$archived = pg_escape_string($_POST['archiveInfo']);	

	//check which  type of data (archived, current, or from both
	if($archived == "current"){
		$gatherSearchResQuery .= " and archived != 1";
	}else if($archived == "archived"){
		$gatherSearchResQuery .= " and archived = 1";
	}	
}





//gathers information for building search query
if(isset($_POST['createdDate']) and $_POST['createdDate'] != ""){
	// for dates, make sure date is set / date range (before,after or on)
	$date = pg_escape_string($_POST['createdDate']);
	$otherDate = pg_escape_string($_POST['completedDate']);

	//verify that another date isnt set, validate if so 	
	if($otherDate != ""){
		valiDate($date, $otherDate);
	}

	//check radios for date range
	if(isset($_POST['radio'])){
		$radio = strtolower(pg_escape_string($_POST['radio']));
		if($radio != ""){
			if($radio == "after"){
				$gatherSearchResQuery .=  " and created_date >= '$date'";
			}else if($radio == "before"){
				$gatherSearchResQuery .= " and created_date <= '$date'";
			}else {
				$gatherSearchResQuery .= " and created_date = '$date'";
			}
		}
	} else {
		// if radio isnt set default to on
		$gatherSearchResQuery .= " and created_date = '$date'";
	}
}




//gathers information for building search query
if(isset($_POST['completedDate']) and $_POST['completedDate'] != ""){
        // for dates, make sure date is set / date range (before,after or on)
        $date = pg_escape_string($_POST['completedDate']);
        $otherDate = pg_escape_string($_POST['createdDate']);

        //verify that another date isnt set, validate if so
        if($otherDate != ""){
                valiDate($otherDate, $date);
        }

        //check radios for date range
        if(isset($_POST['radio2'])){
                $radio = pg_escape_string($_POST['radio2']);

                if($radio != ""){
                        if($radio == "after"){
                                $gatherSearchResQuery .=  " and completed_date >= '$date'";
                        }else if($radio == "before"){
                                $gatherSearchResQuery .= " and completed_date <= '$date'";
                        }else {
                                $gatherSearchResQuery .= " and completed_date = '$date'";
                        }
                }
        } else {
                // if radio isnt set default to on
                $gatherSearchResQuery .= " and completed_date = '$date'";
        }

}





//gathers information for building search query
if(isset($_POST['endUser']) and $_POST['endUser'] != ""){
	$endUser = pg_escape_string($_POST['endUser']);
	$gatherSearchResQuery .= " and end_user = '$endUser'";
	
}


//gathers information for building search query
if(isset($_POST['barcode']) and $_POST['barcode'] != ""){
        $barcode = pg_escape_string($_POST['barcode']);
        $gatherSearchResQuery .= " and barcode = '$barcode'";

}


//gathers information for building search query
if(isset($_POST['modelInfo']) and $_POST['modelInfo'] != ""){
        $modelInfo = pg_escape_string($_POST['modelInfo']);
        $gatherSearchResQuery .= " and model_info = '$modelInfo'";

}

//gathers information for building search query
if(isset($_POST['itemType']) and $_POST['itemType'] != ""){
        $itemType = pg_escape_string($_POST['itemType']);
        $gatherSearchResQuery .= " and inv_item_type = '$itemType'";

}


//gathers information for building search query
if(isset($_POST['completedBy']) and $_POST['completedBy'] != ""){
        $completedBy = pg_escape_string($_POST['completedBy']);
        $gatherSearchResQuery .= " and completed_by = '$completedBy'";

}

//gathers information for building search query
if(isset($_POST['createdBy']) and $_POST['createdBy'] != ""){
        $createdBy = pg_escape_string($_POST['createdBy']);
        $gatherSearchResQuery .= " and created_by = '$createdBy'";

}





//send search query / receive res here
if(($res = pg_query($dbh, $gatherSearchResQuery)) == false) die("Didnt gather search data response");

	
// table title
echo '
	<p style="font-size: 18px; font-weight: 500; position: relative; left: 27px; margin-top: 9px;">Searched Orders</p>

';


// display table contents here
echo '
<table class="table table-hover table-dark">
<thead>
	<tr>
                        <td><a href="https://aries.msussrc.com/apps/workorder/displayPHP/search.php" style="text-decoration:none;color:#afdceb;display:inline-block;"><i>Back</i></a></td>
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


echo '<form action="../displayPHP/orderDetails.php" method="post">';



while($row = pg_fetch_assoc($res)){
        $output = str_getcsv($row['row']);
        $createdDate = substr($output[0], 1);
        $createdBy = $output[1];
	$ID = $output[2];
	$barcode = $output[3];
	$completedDate = $output[4];
	$completedBy = $output[5];
	$assignedTo = $output[6];
	$itemType = $output[7];
	$fromRoom = $output[8];
	$toRoom = $output[9];
	$dueDate = $output[10];
	$modelInfo = $output[11];
	$endUser = $output[12];
	$archived = rtrim($output[13], ")");


	echo "<tr id=inner>";
        echo"<td></td>";
        echo "<td><input type='submit' name='selected' value='$ID' style='height:27px;width:100%;background-color:#afdceb;border-radius: 5px;border-style:none'></input></td>";
        echo "<td>$completedDate</td>";
        echo "<td>$createdDate</td>";
        echo "<td>$dueDate</td>";
        echo "<td>$itemType</td>";
        echo "<td>$modelInfo</td>";
        echo "<td>$endUser</td>";
        echo "<td>$barcode</td>";
        echo "</tr>";
}



echo'</form></table>';



?>
