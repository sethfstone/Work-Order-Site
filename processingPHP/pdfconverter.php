<?php
//library include  / connect to db
include_once "/usr/share/php/fpdf.php";
include_once "../dbi.php";



//Get id for computer / workorder we are gathering information on to build pdf
$emailId = $_POST['email'];
//echo $emailId;

$getPdfQuery = "select * from new_computer_checklist where id = $emailId";
if (($res = pg_query($dbh, $getPdfQuery)) == false) {
  die("Didn't grab information on item");
}




// Store information in variables for use
while($row = pg_fetch_assoc($res))
{
	$assignedTo = $row['assigned_to'];
	$barcode = $row['barcode'];
	$completedBy = $row['completed_by'];
	$completedDate = $row['completed_date'];
	$createdBy = $row['created_by'];
	$createdDate = $row['created_date'];
	$dueDate = $row['due_date'];
	$endUser = $row['end_user'];
	$fromRoom = $row['from_room'];
	$itemType = $row['inv_item_type'];
	$modelInfo = $row['model_info'];
	$toRoom = $row['to_room'];
}

$currDate = now();

//echo $assignedTo; echo $barcode; echo $fromRoom;

// build pdf using library calls
$pdf = new FPDF();
$pdf->AddPage('P', 'Legal');
$pdf->SetFont('Arial', 'B',' 10');
$pdf->Cell(177,10,"Inventory Relocation Form", 0,2,'C');
$pdf->Cell(54,10, "Current Date: " . $currDate, 0,0,'R');
$pdf->Cell(165,10,"Effective Date: " . $dueDate, 0,1,'C');
$pdf->Cell(42,10, "Description: " . $modelInfo, 0,0,'R');
//echo "here";
$pdf->Cell(93,10, "No: " .$barcode , 0,1,'R');
$pdf->Cell(44,10, "Old Location: " . $fromRoom, 0,0,'R',0);
$pdf->Cell(104,10,"New Location: " . $toRoom, 0,1,'R',0);
$pdf->Cell(43,10, "Assigned To: " . $assignedTo, 0,0,'R',0);
//echo "here";
$pdf->Cell(98,10,"Assign To:" . $endUser, 0,1,'R',0);
$pdf->Cell(63,10, "Form Submitted By:" . $completedBy,0,1,'R',0);
$pdf->Cell(75,10, "Assigned To Signautre:____________", 0,1,'R',0);
//echo "here";
//$pdf->drawTextBox('blah blah.', 50, 50, 'C', 'M');
//echo "here";
$pdf->Output('F', '/www/tmp/report.pdf');

header("Location: https://aries.msussrc.com/apps/workorder/processingPHP/sendEmail.php");
?>
