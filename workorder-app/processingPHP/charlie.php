<?php

include_once "/usr/share/php/fpdf.php";
include_once "../dbi.php";

//Get id for computer / workorder we are gathering information on to build pdf
$emailId = 357;

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

$line_height = 10;
$ypos = 10;

// build pdf using library calls
$pdf = new FPDF();
$pdf->AddPage('P', 'Letter');
$pdf->SetFont('Arial', 'B',' 10');
$pdf->SetXY(78,$ypos);
$pdf->Cell(60,10,"Inventory Relocation Form", 0, 0, 'C');

$pdf->SetXY(175.9, $ypos);
$pdf->Cell(30, 10, "Effective Date", 0);

$ypos += $line_height;
$ypos += $line_height;

$pdf->SetXY(10, $ypos);
$pdf->Cell(50, $line_height, "Description: ", 0, 0, 'L');

// Line
$ypos += $line_height;
// Old Location:
$pdf->SetXY(10, $ypos);
$pdf->Cell(95, $line_height, "Old Location: ", 0, 0, 'L');
// New Location:
$pdf->SetXY(110, $ypos);
$pdf->Cell(95, $line_height, "New Location: ", 0, 0, 'L');

// Line
$ypos += $line_height;
// Inventory Assign to:
$pdf->SetXY(10, $ypos);
$pdf->Cell(95, $line_height, "Inventory Assign To: ", 0, 0, 'L');
// Reassign to:
$pdf->SetXY(110, $ypos);
$pdf->Cell(95, $line_height, "Reassign To: ", 0, 0, 'L');

/*
$pdf->Cell(0,10,"Effective Date: " . $dueDate, 0,true,'L');
$pdf->Cell(42,10, "Description: " . $modelInfo, 0,true,'L');
//echo "here";
$pdf->Cell(93,10, "No: " .$barcode , 0,true,'R');
$pdf->Cell(44,10, "Old Location: " . $fromRoom, 0,true,'R',0);
$pdf->Cell(104,10,"New Location: " . $toRoom, 0,true,'R',0);
$pdf->Cell(43,10, "Assigned To: " . $assignedTo, 0,true,'R',0);
//echo "here";
$pdf->Cell(98,10,"Assign To:" . $endUser, 0,true,'R',0);
$pdf->Cell(63,10, "Form Submitted By:" . $completedBy,0,true,'R',0);
$pdf->Cell(75,10, "Assigned To Signautre:____________", 0,true,'R',0);
//echo "here";
//$pdf->drawTextBox('blah blah.', 50, 50, 'C', 'M');
//echo "here";
//$pdf->Output('F', '/www/tmp/report.pdf');
*/
$pdf->Output('I', '/www/tmp/report.pdf');

?>
