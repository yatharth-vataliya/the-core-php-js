<?php

require_once("db.php");
require_once("vendor/autoload.php");
$faker = Faker\Factory::create();
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

function getGender() : string {
	$gender = ['female','male'];
	return $gender[random_int(0,1)];
}

function getImage() : string {
	return random_int(1,15).".jpg";
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


$st = $pdo->prepare('INSERT INTO users_2 (user_name,user_email,mobile_no,gender,location,date,image) VALUES (:user_name,:user_email,:mobile_no,:gender,:location,:date,:image)');

for($i = 0; $i <= 100; $i++){
	$user = getUser();
	$st->bindValue(':user_name',$user[0]);
	$st->bindValue(':user_email',$user[1]);
	$st->bindValue(':mobile_no',getMobileNumber());
	$st->bindValue(':gender',getGender());
	$st->bindValue(':location',getLocation());
	$st->bindValue(':date',getDates());
	$st->bindValue(':image',getImage());
	$st->execute();
}

*/

# for sort_it table data feeding

/*
$st = $pdo->prepare('INSERT INTO sort_it (product_name,description) VALUES (:product_name,:description)');


for($i = 0; $i < 10; $i++){
	$st->bindValue(':product_name',$faker->name);
	$st->bindValue(':description',$faker->text);
	$st->execute();
}
*/
