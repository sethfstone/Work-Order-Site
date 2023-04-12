<?php


// connect to db
include_once '../dbi.php';



//grab id for which order we would like to update general info on
$selectedID = htmlspecialchars($_POST['email']);




//script to auto submti form to return to orderDetails page
echo '
	<script>
		window.addEventListener("load", (event) => {
			var sub = document.getElementById("submit");
			sub.click();
		});
	</script>
';




//begin transaction for updating general info
$beginTransaction = "begin transaction";
if(($result = pg_query($beginTransaction)) == false) die("Didnt begin transaction");




//check for completion info here /update / complete seperately 
$completedDate = $_POST["completedDate"];
$completedBy = $_POST["completedBy"];

if(!empty($completedDate) and !empty($completedBy)){
	echo "here</br>";
	$sendUpdateCompletionQuery = "update new_computer_checklist set completed_date = ($1), completed_by = ($2) where id = $selectedID";
	echo $sendUpdateCompletionQuery;
	$info = array($completedDate, $completedBy);
	pg_query_params($dbh, $sendUpdateCompletionQuery, $info) or die("Didnt update completion info");
}




//flag for checking all required info is present in form
$MissingInfo = 0;




// Gather general info from form / validate required inputs
if(isset($_POST['itemType'])){
	$invItemType = $_POST['itemType'];
}
if(isset($_POST['createdDate'])){
        $CreatedDate = $_POST['createdDate'];
}
if(isset($_POST['createdBy'])){
        $CreatedBy = $_POST['createdBy'];
}
if(isset($_POST['assignedTo'])){
        $AssignedTo = $_POST['assignedTo'];
}else {
        $AssignedTo = "";
}
if(isset($_POST['endUser'])){
        $AssignTo = $_POST['endUser'];
}
if(isset($_POST['fromRoom'])){
        $FromRoom = $_POST['fromRoom'];
}
if(isset($_POST['toRoom'])){
        $ToRoom = $_POST['toRoom'];
}
if(isset($_POST['barcode'])){
        $Barcode = $_POST['barcode'];
}
if(isset($_POST['completedDate'])){
        $CompletedDate = $_POST['completedDate'];
}
if(isset($_POST['completedBy'])){
        $CompletedBy = $_POST['completedBy'];
}
if(isset($_POST['dueDate'])){
        $DueDate = $_POST['dueDate'];
        if(strlen($DueDate) == 0) $DueDate = NULL;
}
if(isset($_POST['modelInfo'])){
        $ModelInformation = $_POST['modelInfo'];
}
if(isset($_POST['copies'])){
	$copies = $_POST['copies'];
}




//Check if all the info is there
if($MissingInfo) die("Missing vital information in general info section");




//update general info
$updateQuery = "update new_computer_checklist set created_by = ($1), barcode = ($2), assigned_to = ($3), from_room = ($4), to_room = ($5), due_date = ($6), model_info = ($7), end_user = ($8) where id=$selectedID";
$values = array($CreatedBy, $Barcode, $AssignedTo, $FromRoom, $ToRoom, $DueDate, $ModelInformation, $AssignTo);
if(($result = pg_query_params($dbh, $updateQuery, $values)) == false) die("Didnt properly update general item information");



//copy workorder functionality
if(!empty($copies)){
	echo $copies;
	$Barcode = '';

	// Send general info to table
        $insertCQuery = "insert into new_computer_checklist (created_by, assigned_to, inv_item_type, from_room, to_room, due_date, model_info, end_user, archived, barcode) values ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10)";
        $arr = array($CreatedBy, $AssignedTo, $invItemType, $FromRoom, $ToRoom, $DueDate, $ModelInformation, $AssignTo, 0, $Barcode);

	foreach($arr as $val){
		echo $val; echo "</br>";
	}

	for($i = 0; $i < $copies-1; $i++){
		if(($res = pg_query_params($dbh, $insertCQuery, $arr)) == false) die("Didnt add copies");
	}
	
}







//commit everything
$commitTransaction = "commit";
if(($result = pg_query($commitTransaction)) == false) die("Didnt commit changes");




//submission button 
echo '
	<form action="../displayPHP/orderDetails.php" method="post">
		<input type="submit" value="'.$selectedID.'" name="submit" id="submit" onload="back()">
	</form>

';


?>
