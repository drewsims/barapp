<?php
	session_start();
	require_once 'dbconfig.php';

	if($_POST)
	{
		$user_name = $_POST['user_name'];
		$user_email = $_POST['user_email'];
		$user_gender = $_POST['user_gender'];
		$user_password = $_POST['password'];
		$joining_date =date('Y-m-d H:i:s');
		
		//$password = md5($user_password);
		$password = password_hash($user_password, PASSWORD_DEFAULT);
		try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM users WHERE userEmail=:email");
			$stmt->execute(array(":email"=>$user_email));
			$count = $stmt->rowCount();
			
			if($count==0){
				
			$stmt = $db_con->prepare("INSERT INTO users(userName,userEmail,userGender,userPassword,joining_date) VALUES(:uname, :email, :gender, :pass, :jdate)");
			$stmt->bindParam(":uname",$user_name);
			$stmt->bindParam(":email",$user_email);
			$stmt->bindParam(":gender",$user_gender);
			$stmt->bindParam(":pass",$password);
			$stmt->bindParam(":jdate",$joining_date);
					
				if($stmt->execute())
				{
					echo "registered";
				}
				else
				{
					echo "Query could not execute !";
				}
			
			}
			else{
				
				echo "1"; //  not available
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM users WHERE userEmail=:email");
			$stmt->execute(array(":email"=>$user_email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
			if($row['userPassword']==$password){
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