<?php
//connect to db
include_once '../processingPHP/dbi.php';

//get id
$selectedID = $_POST['ID'];

var_dump($_POST);

//run sql statement
if(isset($_POST['listItem'])){
	$rs = pg-query-params($dbh, "INSERT INTO options (optionvalue, id) VALUES ($1,$2)", array($_POST['listItem'], $id))
	

}

?>
