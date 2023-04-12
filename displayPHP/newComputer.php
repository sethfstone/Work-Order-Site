<?php
//opens option file and reads in options to display for orders 
	// to change optional options go to options.csv file and add a new column header name and subsequent items for 
	//it on the last line (csv styling)
$optionFile = fopen("../options/options.csv", "r") or die("Unable to open options file");




//Links for bootstrap and fontawesome
echo '<head>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
      </head>';





//display General info section at the top
	// gather information regarding a new workorder
echo '
	<style>input{background-color:#add8e6;border-style:solid;border-color:white; border-radius:3px}</style>

	 <!-- <link rel="stylesheet" href="../css/displayForm.css">  -->
	<h4 style="text-align:center;margin-top:9px">SSRC New Item Checklist</h4>
	<form action="../processingPHP/sendNewCompData.php" method="post">
	<div class="NewComputerFormContainer" style="height: 441px;width: 90%; position:relative; left: 5%; top:5px;border-radius:12px;background-color:#343a40;color:white;font-size:17px">
			<div class="firstLineGen" class="form-floating mb-3" style="margin: 9px auto; display:flex;justify-content:space-evenly">
				<div style="margin-top:9px"><p>Form Created By</p><input type="text" name="CreatedBy"></div> 
				<div style="margin-top:9px"><p>Date Due</p><input type="date" name="DateDue" style="padding-left:12px;width:221px; text-align:center"></div>
			</div>
			<div style="display:flex;justify-content:space-evenly">
				<div class="secondLineGen" style="position:relative;display:block;justify-content:space-evenly">
					<div style="margin-top: 9px;"><p>Inventory Item Type</p><input type="text" name="InvItemType"></div>
					<div style="margin-top: 9px;"><p>Model Information</p><input type="text" name="ModelInfo"></div>
				</div>
				<div class="thirdLineGen" style="display:block;justify-content:space-evenly">
					<div style="margin-top:9px;"><p>Assigned Technician</p><input type="text" name="AssignedTechnician"></div>
					<div style="margin-top:9px"><p>End User</p><input type="text" name="EndUser"></div>
				</div>
			</div>
			<div class="fourthLineGen" style="position:relative;margin-top:9px;z-index:5">
				<div style="float:left;margin-left:17%; margin-top: 9px;"><p>From Location</p><input type="text" name="FromRoom"></div>
				<div style="float:right;margin-right:17%;margin-top: 9px;"><p>To Location</p><input type="text" name="ToRoom"></div>
			</div>
			<div class="lastLineGen" style="position:relative;margin-top: 9px; text-align:center">
				<div style="display:inline-block"><p style="margin-top: 10px;">Barcode/SN</p><input type="text" name="Barcode/SN"></div>
			</div>
	
	</div>';







//Processing options for display
$headers = array();
$lineC = 1;
                      
//Grab first line of options file to process headings
$currOptionLine = fgetcsv($optionFile, ",");
foreach($currOptionLine as $headerName){
	array_push($headers, $headerName);
}

//loop options file for display
while(!feof($optionFile)){
	$currLine = fgetcsv($optionFile, ",");
	$headerVal = $headers[$lineC-1];
	echo "<div style='font-size: 21px;text-align:center;margin-top: 15px;margin-bottom:3px;'>$headerVal</div>";
	echo "<div style='background-color:#343a40;position:relative;left:27.5%;width:45%;border-radius:9px;'>";
	if($lineC){
		foreach($currLine as $rowItem){
			echo "<div class='form-check' style='height:fit-content;display:flex;'>
				<input type='checkbox' name='optional[]' value='$rowItem' style='border-color:white;width:15px;position:relative;left:-9px;'>
				<label style='color:white;margin-top:6px;font-size:17px'>$rowItem</label>
			</div>";
		}
	}
	echo "</div>";
	$lineC++;
}






//foreach($_POST as $row){
//	echo $row;
//}







// comments section / submit button here
echo '
		<!-- Comments section -->

		<div class="input-group" style="width: 45%;position: relative; left: 27.5%;margin-top:9px;">
  			<div class="input-group-prepend" style="border-radius:9px">
    				<span class="input-group-text" style="background-color:#343a40; color:white; border-top-left-radius: 9px; border-bottom-left-radius: 9px">Additional Comments</span>
  			</div>
  			<textarea class="form-control" aria-label="With textarea" id="comments" name="comments" style="border-top-right-radius:9px;"></textarea>
		</div>	

		<!-- Submit new workorder -->
		<div class="submit" style="border-radius:6px;text-align:center;margin-top:18px;"><input style="border-radius:6px;width:200px;height:30px;color:black;border-style:hidden" value="Submit" type="submit" name="submitinfo" ></div>
	</form>	

';
?>

