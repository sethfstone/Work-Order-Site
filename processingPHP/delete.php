<?php
//connecting page to db
include_once 'dbi.php';


//begin sql transaction
if(($result = pg_query($dbh, "begin transaction")) == false) die("Didnt begin deletion transaction");


//delete workorder options from db
$ID = $_POST['value']; 
$deleteQueryOptions = "delete from options where id = $ID";
if(($result = pg_query($dbh, $deleteQueryOptions)) == false) die("Didnt delete from options table");


//delete computer/workorder from db
$deleteQueryNC = "delete from new_computer_checklist where id = $ID";
echo $deleteQueryNC; echo "</br>";
if(($result = pg_query($dbh, $deleteQueryNC)) == false) die("Didnt delete from options table");




//commit transaction or backgtrack
if(($result = pg_query($dbh, "commit")) == false) die("Didnt begin deletion transaction");


//redirect back to history page
header("Location: https://aries.msussrc.com/apps/workorder/displayPHP/history.php");

?>
