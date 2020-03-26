<?php 
#code to deal with forgot password
include ('header.php');

// Check if the form has been submitted.
if (isset($_POST['submitted'])) {
	require_once ('mysql_connect.php'); // Connect to the db.
	$errors = array(); // Initialize error array.

	// Check for an email address.
	if (empty($_POST['email'])) {
		$errors[] = 'You forgot to enter your email address.';
	} else {
		$e = mysql_real_escape_string($_POST['email']);
	}

	if (empty($errors)) { // If everything's okay.
		// Check for previous registration.
		$query = "SELECT * FROM users WHERE email='$e'"; 
		$result = mysql_query($query);
		if (mysql_num_rows($result)==1) {
			while ($row=mysql_fetch_array($result)){
				$p=$row['password']; 
				$u=$row['email']; 
			}								
				// Send an email, if desired.
			$to=$e; 
			$subject="Your final project";
			$body="
			Thank you very much for being a member of\n\n
			Here is your password information.\n\n
			Password: ".$p."\n\n
			Thanks again!\n\n"; 
			$headers="From: Your name <acbrewer@uwm.edu>\n";  // <-- Replace this to your email address!!!
			mail ($to, $subject, $body, $headers); // SEND the message!  

			// Print a message.
			echo '<h1 id="mainhead">Thank you!</h1>
			<p>Please, check your email to get your username and password.</p>'; 

			// Include the footer and quit the script (to not show the form).
			include ('footer.php');
			exit();
		} else { // Not registered.
			echo '<font color=red><h4>Error!</h4>
			<p>The email address is not in our database.</p></font>';
		}

	} else { // Report the errors.
		echo '<font color=red><h4>Error!</h4>
		<p>The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p><p><br /></p></font>';
	} // End of if (empty($errors)) IF.

	mysql_close(); // Close the database connection.
} // End of the main Submit conditional.

?>

<h3>Forgot username or password?</h3>
<form action="forgot.php" method="post">
	Email Address: <input type="text" name="email" size="20" maxlength="40" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> 
	<input type="submit" name="submit" value="Submit" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<p>

<?php
include ('footer.php');
?>
