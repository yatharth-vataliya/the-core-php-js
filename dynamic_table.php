<?php 

require_once("db.php");


$st = $pdo->prepare("SELECT * FROM users_1 WHERE status='active'");
$st->execute();

$users = $st->fetchAll(PDO::FETCH_CLASS);
$no = 1;

$html ='<table class="table table-striped table-hover table-bordered"><thead><tr><th>No.</th><th>Username</th><th>Email</th><th>Rights</th><th>Gender</th><th>City</th><th>Actions</th></tr></thead><tbody>';
		foreach ($users as $user){
			$html .= "<tr><td>$no</td><td>".$user->user_name."</td><td>".$user->user_email."</td><td>".$user->rights."</td><td>{$user->gender}</td><td>{$user->city}</td><td><button type='button' class='btn btn-warning' onclick='editUser({$user->id})'><i class='fas fa-edit'></i></button><button type='button' class='btn btn-danger' onclick='deleteModal(".$user->id.");'><i class='fas fa-trash'></i></button></td></tr>";
			$no++;
		}
		$html .='</tbody></table>';

echo json_encode([
	'html' => $html
]);

?>