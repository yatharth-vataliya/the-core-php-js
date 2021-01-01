<?php 

require_once("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type']) && $_POST['type'] == 'updateGender'){
	$st = $pdo->prepare('UPDATE users_2 SET gender=:gender WHERE id=:user_id');
	$st->bindValue(':gender',$_POST['gender']);
	$st->bindValue(':user_id',$_POST['user_id']);
	$st->execute();
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type']) && $_POST['type'] == 'update'){
	$sql = 'UPDATE users_2 SET user_name=:user_name, user_email=:user_email, mobile_no=:mobile_no, location=:location, date=:date WHERE id=:user_id';

	$st = $pdo->prepare($sql);
	$st->bindValue(':user_name',$_POST['user_name']);
	$st->bindValue(':user_email',$_POST['user_email']);
	$st->bindValue(':mobile_no',$_POST['mobile_no']);
	$st->bindValue(':location',$_POST['location']);
	$st->bindValue(':date',$_POST['date']);
	$st->bindValue(':user_id',$_POST['user_id']);
	$result = $st->execute();
	if($result){
		echo json_encode([
			'check' => true,
			'message' => 'successfully updated',
		]);
	}else{
		echo json_encode([
			'check' => false,
			'message' => 'something went wrong please try again later',
		]);
	}

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type']) && $_POST['type'] == 'delete'){
	$sql = 'DELETE FROM users_2 WHERE id=:user_id';
	$st = $pdo->prepare($sql);
	$st->bindValue(':user_id',$_POST['user_id']);
	$result = $st->execute();
	if($result){
		echo json_encode([
			'check' => true,
			'message' => 'successfully deleted',
		]);
	}else{
		echo json_encode([
			'check' => false,
			'message' => 'something went wrong please try again later',
		]);
	}	
}

?>