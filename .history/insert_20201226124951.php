<?php 

require_once("db.php");
require_once("vendor/autoload.php");

# for seeding users_2 table
/*
function getUser() : Array {
	$usernames = [
		'arjun','karn','nakul','yudhisthir','sahdev','bhim','parixit','abhimanyu','gatochgach'
	];

	$max = count($usernames) - 1;
	$username = $usernames[random_int(0, $max)];
	$useremail = $username.'@gmail.com';
	return [$username,$useremail]; 

}

function getDates() : string {
	$day = random_int(1, 31);
	$month = random_int(1, 12);
	$year = random_int(1999, 2020);
	return date('Y-m-d H:m:s',strtotime("$year/$month/$day"));
}

function getLocation() : string {
	$locations = [
		'kalavad','rajkot','jamnagar','baroda','surat','mota pachdevada'
	];

	return $locations[random_int(0, (count($locations) -1))];
}

function getMobileNumber() : int {
	return random_int(9000000000, 9999999999);
}


$st = $pdo->prepare('INSERT INTO users_2 (user_name,user_email,mobile_no,location,date) VALUES (:user_name,:user_email,:mobile_no,:location,:date)');

for($i = 0; $i <= 100; $i++){
	$user = getUser();
	$st->bindValue(':user_name',$user[0]);
	$st->bindValue(':user_email',$user[1]);
	$st->bindValue(':mobile_no',getMobileNumber());
	$st->bindValue(':location',getLocation());
	$st->bindValue(':date',getDates());
	$st->execute();
}*/

$st = $pdo->prepare('INSERT INTO sorit_it (product_name,description,order_id) VALUES (:prodcut_name,:description,:order_id)');




?>