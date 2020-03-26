<?php
require_once ('dbconfig.php'); 

		//$user_location = $_GET['userLocation'];
		//$rating = $_GET['rating']; 
		$placeId = 0;		
	
	try{
		$stmt = $db_con->prepare("SELECT COUNT(userId) AS Users , AVG(rating) AS Rating FROM bar WHERE placeId = :placeId");
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