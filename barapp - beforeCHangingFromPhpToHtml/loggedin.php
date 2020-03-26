<?php
session_start(); 
include ("header.php"); // Include the header file.
// Print a customized message:
if (!isset($_SESSION['email'])){
	echo "<h1>You have not logged in yet!</h1>";
} else {
	echo "<h1>Logged In!</h1><p>You are now logged in " . $_SESSION['email'] .  $_SESSION['location'] .  $_SESSION['funLevel'] . $_SESSION['gender'] . "!</p>
	<p>You can now enjoy our services for logged in users</p>
	";	
	// Redirect:
			header("Location:index.php");
			exit(); // Quit the script.
} 
include ('footer.php'); // Include the footer file.
?>