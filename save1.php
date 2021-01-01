<?php
session_start();

require_once("db.php");

function checkData(...$data) {
	foreach($data as $value):
		if(is_array($value)):
			foreach($value as $val):
				if(empty($val)):
					return false;
				else:

				endif;
			endforeach;
		else:
			if(empty($value)):
				return false;
			else:

			endif;
		endif;
	endforeach;
	return true;
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$_SESSION['user_name'] = $username = $_POST['user_name'];
	$_SESSION['user_email'] = $useremail = $_POST['user_email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$_SESSION['rights'] = $rights = $_POST['rights'] ?? NULL;
	$_SESSION['gender'] = $gender = $_POST['gender'];
	$_SESSION['city'] = $city = $_POST['city'] ?? '--';
	$_SESSION['user_id'] = (!empty($_POST['user_id'])) ? $_POST['user_id'] : '';
	$_SESSION['submit'] = $_POST['submit'];
	$is_ready = checkData($username,$useremail,$gender);
	checkEmail($useremail);
	if($is_ready){
			$sql = '';
			if($_POST['submit'] == 'save'){
				$sql = 'INSERT INTO users_1 (user_name,user_email,rights,password,gender,city)VALUES(:username,:useremail,:rights,:password,:gender,:city)';

				$msg = 'Saved successfully';
				confirmPassword($password,$confirm_password);
			}elseif($_POST['submit'] == 'update'){
				if(!empty($password)){
					confirmPassword($password,$confirm_password);
				}
				$is_email = checkEmail($_POST['user_email']);
				$sql = 'UPDATE users_1 SET rights=:rights, user_name=:username, user_email=:useremail, password=:password, gender=:gender, city=:city WHERE id=:user_id';
				$msg = 'Updated successfully';
			}

			$st = $pdo->prepare($sql);
			(!empty($_POST['user_id'])) ? $st->bindValue(':user_id',$_POST['user_id']) : '';
			$st->bindValue(':username',$username);
			$st->bindValue(':useremail',$useremail);
			(!empty($rights)) ? $st->bindValue(':rights',implode(',',$rights)) : $st->bindValue(':rights','No rights');
			$st->bindValue(':password',password_hash($password, PASSWORD_DEFAULT));
			$st->bindValue(':gender',$gender);
			$st->bindValue(':city',$city);
			$st->execute();

			/*echo json_encode([
				'check' => true,
				'message' => $msg
			]);*/
			session_destroy();
			session_start();
			$_SESSION['info'] = $msg;
			header("location:prac_11.php");
	}else{
		/*echo json_encode([
			'check' => false,
			'message' => 'Some fields are missing or not filled please fill all the fields first and then try again.'
		]);*/
		$_SESSION['errors'][] = "Some fields are missing or not filled please fill all the fields first and then try again.";
		header("location:prac_11.php");
	}
}

function checkEmail($email = NULL,$user = NULL){
	global $pdo;
	if(filter_var($email,FILTER_VALIDATE_EMAIL)){
		if($_POST['submit'] == 'update'){
			$st = $pdo->prepare('SELECT count(user_email) from users_1 WHERE user_email=:email AND status ="active" AND id NOT IN (:id)');
			$st->bindValue(':id',(int)$_POST['user_id'],PDO::PARAM_INT);
		}else{
			$st = $pdo->prepare('SELECT count(user_email) from users_1 WHERE user_email=:email AND status ="active"');
		}
		$st->bindValue(':email',$email);
		$st->execute();
		$allUser = $st->fetchColumn();
		if(!empty($allUser) || $allUser != "0"){
			/*echo json_encode([
				'check' => false,
				'message' => "it's seems like email is already registered please try with something else"
			]);*/
			$_SESSION['errors'][] = "it's seems like email is already registered please try with something else";
			header("location:prac_11.php");
			die;
		}
	}else{
		/*echo json_encode([
			'check' => false,
			'message' => 'Please Enter Proper Email address'
		]);*/
		$_SESSION['errors'][] = "Please Enter Proper Email Address";
		header("location:prac_11.php");
		die;
	}
}
function confirmPassword($pass,$conf){
	if($pass != $conf){
		/*echo json_encode([
			'check' => false,
			'message' => 'Password Doesn\'t match'
		]);*/
		$_SESSION['errors'][] = "Password Doesn't match";
		header("location:prac_11.php");
		die;	
	}
}

?>