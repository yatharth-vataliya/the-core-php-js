<?php 

require_once("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$ids = $_POST['deletes'];
	$st = $pdo->prepare('DELETE FROM users_2 WHERE id IN(:id)');
	foreach ($ids as $id) {
		$st->bindValue(':id',$id);
		$st->execute();
	}

}


?>