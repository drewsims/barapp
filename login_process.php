<?php
	session_start();
	require_once 'dbconfig.php';
//print_r($_POST);
	if(isset($_POST['btn-login']))
	{
		//$user_name = $_POST['user_name'];
		$user_email = trim($_POST['user_email']);
		$user_password = trim($_POST['password']);
		
		//$password = md5($user_password);
		
		
		try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM users WHERE userEmail=:email");
			$stmt->execute(array(":email"=>$user_email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
			//if($row['userPassword']==$password){
				if(password_verify($user_password, $row['userPassword'])){
				echo "ok"; // log in
				$_SESSION['user_session'] = $row['userId'];
			}
			else{
				
				echo "email or password does not exist."; // wrong details 
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
	}

?>