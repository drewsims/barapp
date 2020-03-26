<?php
session_start();
require_once ('dbconfig.php'); 

	if (!isset($_SESSION['user_session'])){
	echo "You are not logged in my friend!";
	exit();
}else{
	if($_POST)
	{ 
		$user_location = $_POST['userLocation'];
		$rating = $_POST['rating'];
		$placeId = $_POST['placeId']; 
		$dateRated = date('Y-m-d H:i:s');
	}else{
		//$user_location = $_GET['userLocation'];
		//$rating = $_GET['rating']; 
		$placeId = $_GET['placeId'];
	}
		try
		{
			$stmt = $db_con->prepare("SELECT * FROM users WHERE userId=:userId");
			$stmt->execute(array(":userId"=>$_SESSION['user_session']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
		if($count==1){
				
			$stmt = $db_con->prepare("UPDATE users SET userLocation=:location WHERE userId = :user_session");
			$stmt->bindParam(":location",$user_location);
			$stmt->bindParam(":user_session",$_SESSION['user_session']);					
				$stmt->execute();
						
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
			$stmt = $db_con->prepare("SELECT * FROM bar WHERE userId=:userId AND placeId = :placeId");
			$stmt->execute(array(":userId"=>$_SESSION['user_session'],":placeId"=>$placeId));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$count = $stmt->rowCount();
			
			if($count){
			$stmt = $db_con->prepare("UPDATE bar SET placeId=:placeId, userId=:userId, rating=:rating, dateRated=:dateRated WHERE userId = :userId AND placeId = :placeId");
			$stmt->bindParam(":placeId",$placeId);
			$stmt->bindParam(":userId",$_SESSION['user_session']);
			$stmt->bindParam(":rating",$rating);
			$stmt->bindParam(":dateRated",$dateRated);
					
				if($stmt->execute())
				{
					echo "Thanks for Rating!";
				}
				else
				{
					echo "bar update Query could not execute !, ";
				}
			
			}
			else if($count==0){
				
				$stmt = $db_con->prepare("INSERT INTO bar (placeId, userId, rating, dateRated) values (:placeId, :userId, :rating, :dateRated)");
				$stmt->bindParam(":placeId",$placeId);
				$stmt->bindParam(":userId",$_SESSION['user_session']);
				$stmt->bindParam(":rating",$rating);
				$stmt->bindParam(":dateRated",$dateRated);
			
				if($stmt->execute())
				{
					echo "Thanks for Rating!";
				}
				else
				{
					echo "Query could not execute !";
				}
			}	
			else{
				echo "error inserting bar rarting";
			}
		}
		catch(PDOException $e){
			echo $e->getMessage();
		} 
	} 
	
	/* try{
		$stmt = $db_con->prepare("SELECT COUNT(userId) AS Users FROM bar WHERE placeId = :placeId");
		$stmt->bindParam(":placeId",$placeId);
		$stmt->execute();
		//$_SESSION['userCount']=$row['Users'];
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo $row['Users'];
	}	
	catch(PDOException $e){
	echo $e->getMessage();} 
	
	}	*/
?>