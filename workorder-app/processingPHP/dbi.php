<?php

/*

For security reasons, this file should not contain any HTML.  The
connection info below must never be viewable from a web browser

*/


// Connection info for postgresql 

$pg_hostname = 'localhost';
$pg_port     =  5432;
$pg_database = 'postgres';
$pg_user     = 'workorder';
$pg_dbpass   = 'hueylewis';
$dbschema    = 'workorder';

$hello_postgres = "host=$pg_hostname " .
                  "port=$pg_port " .
                  "dbname=$pg_database " .
                  "user=$pg_user " .
                  "password=$pg_dbpass";


//connect
$dbh = pg_connect($hello_postgres);




function now() {
  global $dbh, $dbschema;
  $rs = pg_query($dbh, "SELECT now()");
  return pg_fetch_array($rs)[0];
}


?>
