<?php
//library include  / connect to db
include_once "/usr/share/php/fpdf.php";
include_once "../dbi.php";
include_once 'textbox.php';


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

// build pdf using library calls
$line_height = 10;
$ypos = 10;

// build pdf using library calls
$pdf=new PDF_TextBox();
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

//Line
$ypos += $line_height;
//Form Submitted By:
$pdf->SetXY(10, $ypos);
$pdf->Cell(95, $line_height, "Form Submitted By: ", 0, 0, 'L');

//Line
$ypos += $line_height;
//Assigned To Signature:
$pdf->SetXY(10, $ypos);
$pdf->Cell(95, $line_height, "Assigned To Signature: ", 0, 0, 'L');

//Line
$ypos += $line_height;
//Notes
$pdf->SetXY(10, $ypos);
$pdf->Cell(95, $line_height, "Notes: ", 0, 0, 'L');

//Textbox requires class
$pdf=new PDF_TextBox();
$pdf->SetXY(10, $ypos);
$pdf->drawTextBox('This is a test', 50, 50, 'C');
$pdf->Output('I', 'www/tmp/report.pdf');
//$pdf->Output('F', '/www/tmp/report.pdf');

//header("Location: https://aries.msussrc.com/apps/workorder/processingPHP/sendEmail.php");
?>
