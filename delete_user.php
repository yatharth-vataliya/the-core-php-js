<?php 

require_once("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$st = $pdo->prepare('UPDATE users_1 SET status="inactive" WHERE id=:user_id');
	$st->bindValue(':user_id',$_POST['user_id']);
	$result = $st->execute();

	if($result){
		echo json_encode([
			'message' => 'User successfully Deleted'
		]);
	}

}


 ?>