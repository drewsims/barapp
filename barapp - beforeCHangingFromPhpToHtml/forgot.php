<?php 
session_start();
	require_once 'dbconfig.php';
//print_r($_POST);
	if(isset($_POST['btn-forgot']))
	{
		$user_email = trim($_POST['user_email']);
		
			try
		{	
		
			$stmt = $db_con->prepare("SELECT * FROM users WHERE userEmail=:email");
			$stmt->execute(array(":email"=>$user_email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
			if($row['userEmail']==$user_email){
				require_once("recoveryEmail.php");
			}
			else{
				
				echo "email does not exist."; // wrong details 
			}
				
		}
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		}
?>
