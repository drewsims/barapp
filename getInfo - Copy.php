<?php
session_start();
require_once ('dbconfig.php'); 

	if (!isset($_SESSION['user_session'])){
	echo "You are not logged in!";
	exit();
}else{
		//$user_location = $_GET['userLocation'];
		//$rating = $_GET['rating']; 
		$placeId = $_GET['placeId'];		
	
	try{
		$stmt = $db_con->prepare("SELECT COUNT(userId) AS Users , AVG(rating) AS Rating FROM bar WHERE placeId = :placeId");
		$stmt->bindParam(":placeId",$placeId);
		$stmt->execute();
		//$_SESSION['userCount']=$row['Users'];
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	}	
	catch(PDOException $e){
	echo $e->getMessage();} 
	
	}
?>
