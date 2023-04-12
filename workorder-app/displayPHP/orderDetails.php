<?php
//connect with sql db
include_once '../processingPHP/dbi.php';


// fontawesome / bootstrap stuff
echo '<head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">';
echo '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>';





$flag = 0;
// grab information on selected computer
$selectedID = htmlspecialchars($_POST['selected']);

if($selectedID == ""){
	$selectedID = $_POST['submit'];
}




//grab all the general info
$getGenInfoQuery = "select * from new_computer_checklist where id=$selectedID";
if(($res = pg_query($dbh, $getGenInfoQuery)) == false){die("Didnt grab information on item");}
if($res){
	while($row = pg_fetch_array($res)){
		$itemType = $row['inv_item_type'];
		$fromRoom = $row['from_room'];
		$toRoom = $row['to_room'];
		$dueDate = $row['due_date'];
		$modelInfo = $row['model_info'];
		$endUser = $row['end_user'];
		$assignedTo = $row['assigned_to'];
		$completedBy = $row['completed_by'];
		$completedDate = $row['completed_date'];
		$barcode = $row['barcode'];
		$createdBy = $row['created_by'];
		$createdDate = $row['created_date'];
	}

	
}



// grab optional info here
$getDetailedInfoQuery = "select * from options where id=$selectedID";
if(($detRes = pg_query($dbh, $getDetailedInfoQuery)) == false){die("Didnt grab detailed info on item");}



$incompleteList = array();



//some styling 
echo '
	<style>
		label {
			color:white;
		}	
	
		.checkbox{
			position: absolute;
			top: 18px;
			left: 9px;
			height: 15px;
			width: 15px;
			background-color:red;
			display:none;
		}
	</style>

';





//submit button for emailing necessary people PDF with workorder information 
	//                                         => (for keeping up with inventory)
echo '
	<form action="../processingPHP/pdfconverter.php" method="post">
		<input type="submit" id="emailItem" value="$'.$selectedID.'" style="position:relative;top:-400px;">
	</form>

';





// used for "checking off" items in to-do list
echo '
        <script>

                function check(){
                        var checkbox = document.getElementsByClassName("items"); //loop through items every time one is clicked and update html
			for(var i = 0; i < checkbox.length; i++){
				if(checkbox[i].checked){ // if clicked and set to true
					//change html to cross out text
					checkbox[i].parentElement.style.textDecoration = "line-through";
					
				}else{
					checkbox[i].parentElement.style.textDecoration = "none";
				}
			}			

                }

		function sendEmail(){
			var item = document.getElementById("emailItem");
			item.click();
		}

		function back(){
			window.location = "https://aries.msussrc.com/apps/workorder";
		}

		function uncheck(){
			var items = document.querySelectorAll("input[type=checkbox]");

			for(var i = 0; i < items.length; i++){
				if(items[i].checked){
					items[i].click();
				}
			}

			window.location = "https://aries.msussrc.com/apps/workorder/processingPHP/updateProgress.php";
		}

        </script>
';





// display information here 
echo '

	<div style="display:flex; width:95%;height:100%;position:relative; left:2.5%;">
		<div style="width:80%;height:800px">
			<form name="updateGeneral" method="post" action="../processingPHP/updateGeneral.php">
				<input type="text" value="'.$itemType.'" name="itemType" style="position:relative;left:-2000px;top:-1000px;">
				<input  type="submit" name="email" value="'.$selectedID.'" placeholder="test" style="position:relative;width:fit-content;height:30px;margin-right: 18px;margin-top:-500px;top:-5000px;left:-2000px;" >

			<div style="width:100%;height: 423px;border-radius:9px;background-color:#495057;position:relative;top:-27px;">
			 	<div style="text-align:center; width: 100%;display:flex;justify-content:space-evenly">

					<button id="back" name="back" class="btn btn-light" onclick="back()" formaction="../index.php" style="height:36px;text-align:center;position:relative; left:-12%;top:18px;">Home</button>
';


//display item dependent logo here
      if(!empty($itemType)){
              if(strtolower($itemType) == "computer"){
              echo '
                      <img src="../css/images/2.png" style="max-height:90px;max-width:90px;display:block;position:relative;">
              ';
              }else if(strtolower($itemType) == "laptop"){
              echo '
                      <img src="../css/images/3.png"  style="width:80%;max-height:70px;max-width:70px;display:block;margin-top:9px;position:relative;right:-5px;margin-bottom:6px;">
              ';
              }else if(strtolower($itemType) == "printer"){
              echo '
                      <img src="../css/images/1.png" style="width:80%;max-height:70px;max-width:70px;margin-top:3px;display:block;position:relative;right: -15px">
                      ';
              }
	      else {
		echo '
			<img src="../css/images/logo.png" style="width:70px;height:70px;top:9px;position:relative;margin-bottom: 18px; border-radius:6px;">
		';
		}
      }

// display general info here
echo'
                                       <button id="email" value="'.$selectedID.'" class="btn btn-light" name="email" formaction="../processingPHP/pdfconverter.php" style="position:relative;top:18px;left:12%;height:36px;" onclick="sendEmail()">Email</button>

				</div>
				<div class="itemInfo" style="width:100%;display:flex">
					<div class="firstInfoHolder" style="width:100%;height:100%;">
						<div style="width:100%;height:150px;display:flex;justify-content:space-around;left:12px;position:relative;top:6px;">
							<div style="display:block"><div><label>Barcode</label></div><div><input type="text" name="barcode" value="'.$barcode.'" style="background-color:#e5e4e2;width:81%;border-radius:3px;border-style:none;"></div></div>
							<div style="display:block"><div><label>Due Date</label></div><div><input type="text" name="dueDate" value="'.$dueDate.'" style="background-color:#e5e4e2; width:81%; height: 27px; border-radius:3px; ;border-style:none;"></div></div>
							<div style="display:block"><div><label>Model Info</label></div><div><input type="text" name="modelInfo" value="'.$modelInfo.'" style="background-color:#e5e4e2;width:81%;border-radius:3px;border-style:none"></div></div>
						</div>
						<div style="width:100%;height:150px;position:relative;top:-75px;left:12px; display:flex; justify-content:space-around">
							<div style="display:block;"><div><label>End User</label></div><div><input type="text" name="endUser" value="'.$endUser.'" style="background-color:#e5e4e2;width:81%; border-radius:3px;border-style:none;"></div></div>
                                                	<div style="display:block"><div><label>From Room</label></div><div><input type="text" name="fromRoom" value="'.$fromRoom.'" style="background-color:#e5e4e2;width:81%; border-radius:3px;border-style:none"></div></div>
                                                	<div style="display:block;"><div><label>To Room</label></div><div><input type="text" name="toRoom" value="'.$toRoom.'" style="background-color:#e5e4e2;width:81%; border-radius:3px;border-style:none;"></div></div>
						</div>
					</div>
				</div>
	
				<div class="formInfo" style="height:150px;position:relative;top:-120px;">
					<div style="height:50%;display:flex;justify-content:space-around;position:relative;left:15px;">
						<div style="display:block"><div><label>Created By</label></div><div><input type="text" name="createdBy" value="'.$createdBy.'" style="background-color:#e5e4e2;width:81%; border-radius:3px; border-style:none"></div></div>
						<div style="display:block"><div><label>Created Date</label></div><div><input readonly type="text" name="createdDate" value="'.$createdDate.'" style="width:81%; border-color:white; border-radius:3px; border-style:none;background-color:#c5cbdf"></div></div>
						<div style="display:block"><div><label>Technician</label></div><div><input type="text" name="assignedTo" value="'.$assignedTo.'" style="width:81%; background-color:#e5e4e2; border-radius:3px; border-style:none"></div></div>
					</div>
					<div style="height:50%;display:flex;justify-content:space-around;position:relative;left:15px;">
						 <div style="display:block"><div><label>Completed Date</label></div><div><input type="text" name="completedDate" value="'.$completedDate.'" style="width:81%; background-color:#c0d7df;border-radius:3px; border-style:none"></div></div>
						 <div style="diplay:block"><div><label>Number of Copies</label></div><div><input type="number" id="copies" name="copies" min="2" max="100" style="width: 81%; background-color:#e5e4e2;border-radius:3px; border-style:none"></div></div>
						 <div style="display:block"><div><label>Completed By</label></div><div><input type="text" name="completedBy" value="'.$completedBy.'" style="width:81%;background-color:#c0d7df;  border-radius:3px; border-style:none"></div></div>
					</div>
				</div>
			</div>

';

echo '</form>';



// seperate form for optional information (so you can update the different tables seperately)
echo '<form method="post" action="../processingPHP/updateOptions.php">';




//Completed items displayed here
echo '

		<div style="width:100%; fit-content; background-color:blue;margin-top:18px;padding-bottom: 18px;border-radius:9px;background-color:#495057;margin-bottom: 30px">
			<div>
				<h4 style="color:white;text-align:center;padding-top:9px;padding-bottom:3px">Completed Tasks</h4>
			</div>
';



//Loop over array of optional items and filter by incomplete / complete 
while($row = pg_fetch_assoc($detRes)){
	if($row['completed'] == 1){
		echo '
			<div style="height:fit-content;background-color:#c5cbdf;  width:78%; position: relative; left:11%; margin-top: 12px; margin-bottom: 12px;border-radius:6px; border-style: solid; border-width: 3px; border-color: white">
				<label class="bigcheck" style="display:flex;color:black;margin-bottom: 0">
					<input type="checkbox" name="incomplete[]" value="'.$row["optionvalue"].'" id="inc" style="margin-left:9px;margin-right: 9px; ">
					<p style="height: fit-content; text-align:center; margin-top: 12px">'.$row["optionvalue"].'</p>
				</label>
			</div>	
		';
	// push incomplete items to incomplete list
	} else { array_push($incompleteList, $row);}
}

echo '</div></div></float>';






//Display right hand side info here (incomplete items)
echo'
		<div style="float:right;background-color:#495057;width:38%;border-radius:9px;margin-left: 4%;height:fit-content;margin-bottom: 30px;">
			<div>
				<h3 style="text-align:center;color:white;margin-top:6px;margin-bottom:9px;top:3px;">To Do</h3>
			</div>

';

$itemCount = 0;

foreach($incompleteList as $val){
	$itemCount++;

	echo '
                        <div style="width: 90%; position:relative;left:5%;margin-top:9px;margin-bottom:12px;" class="list">
                                <div style="width:100%; background-color:#c0d7df;display:flex;border-radius:6px; border-style:solid; border-color:white;height:fit-content;vertical-align:middle"><input id="items" class="items" onclick="check()" type="checkbox" style="margin-left:9px;" name="optional[]" value="'.$val['optionvalue'].'"><p style="margin-left:12px;position:relative;top:7px;" id="value">'.$val['optionvalue'].'</p></div>

			</div>
                ';
}



// if no options display msg saying so 
if($itemCount == 0){
	echo '<div style="text-align:center;margin-top:3px"><p style="color:white">Caught up!</p></div>';
}





echo '</div></div>';



//hidden input / submit for edit / update query for the particular computer displayed
echo '
	<input type="hidden" name="ID" value="'.$selectedID.'" syle="position:right; top:400px;">
	<input type="submit" style="display:none;position:right; top: 400px;">
</form>
';


echo '<form action="../processingPHP/updateProgress.php" method="post">';
echo '<button style="position:absolute;top:524px;left:9.3%;" name="test" value="'.$selectedID.'" class="btn btn-light">Undo Progress</button> ';
//echo '<input type="submit" value="test" name="test"></input>';
echo '</form>';



//text box to add to the to do list with a submit button
echo'
<form action="../processingPHP/addAdditionalOption.php" method="post">
//<input type="text" name="listitem" value="'.$listItem.'", style="position:relative; top:-300px; left:200px; width:300px"/>
	<input type = "submit" value="'.$selectedID.'" name="submit" id="submit" style="position:relative; top:-300px; left:200px;  height: 35px; width:65px"/>
</form>
';

//update the table to insert the new input values into the to do list 
//"INSERT INTO options (optionvalue, id, completed)"
//"VALUES ($listItem,$id,0)";


//ADD $listItem optionvalue not null;
 
?>
