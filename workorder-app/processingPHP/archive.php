<?php
//connect page with db
include_once '../dbi.php';

//grab id for order we are archiving
$selectedID = $_POST['submit'];

//update archived field accordingly
$archiveQuery = "update new_computer_checklist set archived = 1 where id=$selectedID";
if(($row = pg_query($dbh, $archiveQuery)) == false) die("Didnt archive item properly");

//redirect back to history
header("Location: https://aries.msussrc.com/apps/workorder/displayPHP/history.php");
?>
