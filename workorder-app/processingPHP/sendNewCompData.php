<?php
	// connect w sql db
	include_once 'dbi.php';
	

// 	begin transaction for data post
	if(pg_query($dbh, "BEGIN;") == false) die("Didn't begin db transaction");


	$MissingInfo = 0;

	// Gather general info from form / validate required inputs
	$DateCreated = now();
	
	if(isset($_POST['CreatedBy'])){
		$CreatedBy = $_POST['CreatedBy'];
		if(strlen($CreatedBy) == 0) $MissingInfo++;
	}	
	if(isset($_POST['InvItemType'])){
                $invItemType = $_POST['InvItemType'];
		if(strlen($invItemType) == 0) $MissingInfo++;
        }
	if(isset($_POST['AssignedTechnician'])){
                $AssignedTo = $_POST['AssignedTechnician'];
        }else {
		$AssignedTo = "";
	}
	if(isset($_POST['EndUser'])){
                $AssignTo = $_POST['EndUser'];
		if(strlen($AssignTo) == 0) $MissingInfo++;
        }
	if(isset($_POST['FromRoom'])){
                $FromRoom = $_POST['FromRoom'];
        }
	if(isset($_POST['ToRoom'])){
                $ToRoom = $_POST['ToRoom'];
        }
	if(isset($_POST['Barcode/SN'])){
                $Barcode = $_POST['Barcode/SN'];
        }
	if(isset($_POST['CompletedDate'])){
		$CompletedDate = $_POST['CompletedDate'];
	}
	if(isset($_POST['CompletedBy'])){
		$CompletedBy = $_POST['CompletedBy'];
	}
	if(isset($_POST['DateDue'])){
		$DueDate = $_POST['DateDue'];
		if(strlen($DueDate) == 0) $DueDate = NULL; echo $DueDate;
	}
	if(isset($_POST['ModelInfo'])){
		$ModelInformation = $_POST['ModelInfo'];
	}




	if($MissingInfo){
		die("Form didn't have all data required (created by field, inv item type field, and end user field)");
	} else {

		// Send general info to table to make new order record
		$insertNCQuery = "insert into new_computer_checklist (created_by, barcode, assigned_to, inv_item_type, from_room, to_room, due_date, model_info, end_user, archived) values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
		$arr = array($CreatedBy, $Barcode, $AssignedTo, $invItemType, $FromRoom, $ToRoom, $DueDate, $ModelInformation, $AssignTo, 0);

		echo '<div><p>';
		foreach($arr as $value){if($value == ""){echo "space";}echo $value; echo "</br>";}
		echo '</div></p>';


		$resultNCAdd = pg_query_params($dbh, $insertNCQuery, $arr);
		if($resultNCAdd == false){
			die("Didnt send general info to new_computer_checklist");
		} else {
			// Get current value of id counter 
			$currQuery = "select last_value from counter;";
        		if(($currID = pg_query($dbh, $currQuery)) == false){exit("Didnt get id properly"); }
       			$row =pg_fetch_assoc($currID);
        		$currID = $row['last_value'];
			echo $currID;

			
			// send optional info to tbale
			if(!empty($_POST['optional'])){
				foreach($_POST['optional'] as $value){
					echo $value;
					echo "</br>";
	
					

					$optionsInsertQuery = "insert into options (optionvalue, id, completed) values ($1, $2, $3)";
					$optionParams = array($value, $currID, 0);
					echo $optionsInsertQuery; echo "</br>";
				
					if(pg_query_params($dbh, $optionsInsertQuery, $optionParams) == false){die("Didnt send the optional data to db");}
		
					
				}

			//add comment to options db

				$value = htmlspecialchars($_POST['comments']);
				if(!empty($value)){
					$optionalQuery = "insert into options values ('$value', $currID, 0)";
					echo $optionalQuery; echo "</br>";
					if(pg_query($dbh, $optionalQuery) == false){die("Didnt send comments to options db");}
				}else { echo "empty comment"; }
			} else { echo "Did not send any optional information to db";}



			//commit changes 
			if(pg_query($dbh, "COMMIT;") == false) die("Didn't commit changes to db");
	
						

		}
	}

	//redirect to home page
	header("Location: https://aries.msussrc.com/apps/workorder");
	
?>
