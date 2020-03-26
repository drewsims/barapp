<?php
session_start();
require_once ('dbconfig.php'); 

		//$user_location = $_GET['userLocation'];
		//$rating = $_GET['rating']; 
		$placeId = $_GET['placeId'];		
	
	try{
		$stmt = $db_con->prepare("SELECT COUNT(userId) AS Users , CAST(AVG(rating) as DECIMAL (10,2))  AS Rating FROM bar WHERE placeId = :placeId");
		$stmt->bindParam(":placeId",$placeId);
		$stmt->execute();
		//$_SESSION['userCount']=$row['Users'];
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		foreach($row as $key => $val)
		{
			if ($val == null){
				$row[$key] = '0';
			}			
		}		
		echo json_encode($row);
	}	
	catch(PDOException $e){
	echo $e->getMessage();} 
	
	
?>
