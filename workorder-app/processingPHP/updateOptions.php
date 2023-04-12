<?php

//connect to db
include_once '../dbi.php';


//submit button click event
echo '
        <script>
                window.addEventListener("load", (event) => {
                        var sub = document.getElementById("submit");
			
                      	sub.click();
                });

        </script>

';





// begin transaction
$beginTransaction = "begin transaction";
if(($result = pg_query($beginTransaction)) == false) die("Didnt begin transaction");




//grab id for computer / order we are upating
$selectedID = $_POST['ID'];





//update optional information
foreach($_POST['optional'] as $val){
        $completeItemQuery = "update options set completed = 1 where optionvalue = '$val' and id = '$selectedID'";
        if(pg_query($dbh, $completeItemQuery) == false) die("Didnt update options table");
}

foreach($_POST['incomplete'] as $incVal){
        $incompleteItemQuery = "update options set completed = 0 where optionvalue = '$incVal' and id = '$selectedID'";
        if(pg_query($dbh, $incompleteItemQuery) == false) die("Didnt update options table (incomp)");
}







// commit transaction
$commitTransaction = "commit";
if(($result = pg_query($commitTransaction)) == false) die("Didnt commit transaction");



//submit button form
echo '
                <form action="../displayPHP/orderDetails.php" method="post">
                           <input type="submit" value="'.$selectedID.'" name="submit" id="submit">

                </form>
';



?>
