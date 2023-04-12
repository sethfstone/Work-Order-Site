<?php
//connect to the database
include_once '../dbi.php';



//grab id for computer & order
$selectedID = $_POST['test'];

echo'
<script>
	function click(){
		var btn = document.getElementById("id");
		btn.click();
	}
</script>
';

//echo $selectedID;



//Update to do list list (changing value to 0)
$todoTaskQuery = "update options set completed = 0 where id = $selectedID and completed=1";
//echo $todoTaskQuery;
//var_dump($_POST);




//run query
if(($result = pg_query($dbh, $todoTaskQuery)) == false) die ("Didn't commit transaction");

echo '<body onload="click()">';
echo '<form method="post" action="../displayPHP/orderDetails.php"><input style="display:none" id="id" type="submit" name="selected" value="'.$selectedID.'"></form>';
echo '</body>';



?>
