<?php # Script - mysqli_connect.php

//This file contains the database access information.
//This file also establishes a connection to MySQL

//Make the connection. 
$dbc = @mysql_connect ("localhost", "root", "")
OR die ('Could not connect to MySQL: ' . mysql_error());

//Select the database (Change your db_name).
@mysql_select_db("barapp")
or die ('Could not select the database: ' . mysql_error());

?>