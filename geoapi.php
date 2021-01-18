<?php 

require_once("db.php");
if($_SERVER['REQUEST_METHOD'] == 'GET'){

	$sql;
	$param;
	if(!empty($_GET['country_id'])){
		$sql = 'SELECT * FROM states WHERE country_id=:id';
		$param = $_GET['country_id'];
	}

	if(!empty($_GET['state_id'])){
		$sql = 'SELECT * FROM cities WHERE state_id=:id';
		$param = $_GET['state_id'];
	}

	$st = $pdo->prepare($sql);
	$st->bindValue(':id',$param,PDO::PARAM_INT);
	$st->execute();
	$data = $st->fetchAll(PDO::FETCH_OBJ);

	echo json_encode([
		'data' => $data
	]);

}

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type'])){
	$message;
	if($_POST['type'] == 'save'){
		$sql = 'INSERT INTO geoinfo (city_id) VALUES (:city_id)';
		$message = "City saved successfully";
	}

	if($_POST['type'] == 'update'){
		$sql = 'UPDATE geoinfo SET city_id=:city_id WHERE id=:geo_id';
		$message = "City udpated successfully";
	}

	if(($_POST['type'] == 'save' || $_POST['type'] == 'update') && !empty($_POST['city_id'])){
		$st = $pdo->prepare($sql);
		$st->bindValue(':city_id',$_POST['city_id'],PDO::PARAM_INT);
		(!empty($_POST['geoinfo'])) ? $st->bindValue(':geo_id',$_POST['geoinfo'],PDO::PARAM_INT) : '';
		$result = $st->execute();
		if($result){
			echo json_encode($message);
			die;
		}
	}
	if($_POST['type'] == 'edit' && !empty($_POST['geo_id'])){
		$st = $pdo->prepare('SELECT * FROM geoinfo WHERE id='.$_POST['geo_id']);
		$st->execute();
		$geo = $st->fetchAll(PDO::FETCH_OBJ);
		$st = $pdo->prepare('SELECT * FROM cities WHERE id='.$geo[0]->city_id.' LIMIT 1');
		$st->execute();
		$city = $st->fetchAll(PDO::FETCH_OBJ);
		$st = $pdo->prepare('SELECT * FROM states WHERE id='.$city[0]->state_id.' LIMIT 1');
		$st->execute();
		$state = $st->fetchAll(PDO::FETCH_OBJ);
		$st = $pdo->prepare('SELECT * FROM countries WHERE id='.$state[0]->country_id.' LIMIT 1');
		$st->execute();
		$country = $st->fetchAll(PDO::FETCH_OBJ);
		/*$st = $pdo->query('SELECT * FROM states WHERE country_id='.$country[0]->id);
		$all_state = $st->fetchAll(PDO::FETCH_OBJ);*/
		echo json_encode([
			'city' => $city,
			'state' => $state,
			// 'all_state' => $all_state,
			'country' => $country
		]);
	}
}

?>