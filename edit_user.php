<?php 

require_once("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['type'] == 'edit'){
	$st = $pdo->prepare('SELECT * FROM users_1 WHERE id=:user_id');
	$st->bindValue(':user_id',$_POST['user_id']);
	$result = $st->execute();
	$user = $st->fetch(PDO::FETCH_OBJ);
	if($user != NULL){
		$rights = explode(',',$user->rights);
		$html ='
		<input type="hidden" value="'.$user->id.'" name="user_id">
		<div class="row p-2">
		<div class="col-md-4">
		Name
		</div>
		<div class="col">
		<input type="text" name="user_name" id="user_name" value="'.$user->user_name.'" class="form-control">
		</div>
		</div>
		<div class="row p-2">
		<div class="col-md-4">
		Email
		</div>
		<div class="col">
		<input type="email" name="user_email" id="user_email" value="'.$user->user_email.'" class="form-control">
		</div>
		</div>
		<div class="row p-2">
		<div class="col-md-4">
		Gender
		</div>
		<div class="col-md-4">
		<input type="radio" name="gender" id="gender" value="male"'.(($user->gender == "male") ? "checked" : "").'>
		Male
		<input type="radio" name="gender" id="gender" value="female"'.(($user->gender == "female") ? "checked" : "").'>
		Female
		</div>
		</div>
		<div class="row p-2">
		<div class="col-md-4">
		City
		</div>
		<div class="col-md-4">
		<select name="city" id="city" class="custom-select">
		<option value="Rajkot" '.(($user->city == "Rajkot") ? "selected" : "").'>Rajkot</option>
		<option value="Jamnagar" '.(($user->city == "Jamnagar") ? "selected" : "").'>Jamnagar</option>
		<option value="Surat" '.(($user->city == "Surat") ? "selected" : "").'>Surat</option>
		<option value="Baroda" '.(($user->city == "Baroda") ? "selected" : "").'>Baroda</option>
		</select>
		</div>
		</div>
		<div class="row p-2">
		<div class="col-md-4">
		Password
		</div>
		<div class="col">
		<input type="password" name="password" id="password" class="form-control">
		</div>
		</div>
		<div class="row p-2">
		<div class="col-md-4">
		Confirm Password
		</div>
		<div class="col">
		<input type="password" name="confirm_password" id="confirm_password" class="form-control">
		</div>
		</div>
		<input type="checkbox" name="rs[]" value="Dashboard"'.(in_array("Dashboard",$rights) ? "checked" : "" ).'> Dashboard<br/>
		<input type="checkbox" name="rs[]" value="Provider List" '.(in_array("Provider List",$rights) ? "checked" : "" ).'> Provider List<br/>
		<input type="checkbox" name="rs[]" value="Customer List" '.(in_array("Customer List",$rights) ? "checked" : "" ).'> Customer List<br/>
		<input type="checkbox" name="rs[]" value="Job List" '.(in_array("Job List",$rights) ? "checked" : "" ).'> Job List<br/>
		<input type="checkbox" name="rs[]" value="Reviews" '.(in_array("Reviews",$rights) ? "checked" : "" ).'> Reviews<br/>
		<input type="checkbox" name="rs[]" value="Complaint List" '.(in_array("Complaint List",$rights) ? "checked" : "" ).'> Complaint List<br/>
		<input type="checkbox" name="rs[]" value="Provider Apporval List" '.(in_array("Provider Apporval List",$rights) ? "checked" : "" ).'> Provider Approval List<br/>
		<input type="checkbox" name="rs[]" value="Needs Approval" '.(in_array("Needs Approval",$rights) ? "checked" : "" ).'> Needs Approval<br/>
		<input type="checkbox" name="rs[]" value="Provider Approved" '.(in_array("Provider Approved",$rights) ? "checked" : "" ).'> Provider Approved<br/>
		<input type="checkbox" name="rs[]" value="Faq List" '.(in_array("Faq List",$rights) ? "checked" : "" ).'> Faq List<br/>';

		echo json_encode([
			'user' => $user,
			'html' => $html
		]);
	}

}
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['type'] == 'update'){
	$gender = $_POST['gender'] ?? 'male';
	$city = $_POST['city'] ?? '--';
	if(!empty($_POST['user_id'])){
		$st = $pdo->prepare('SELECT * FROM users_1 WHERE id='.$_POST['user_id'].' limit 1');
		$st->execute();
		$user = $st->fetch(PDO::FETCH_OBJ);
		$is_email = checkEmail($_POST['user_email'],$user);
		if($is_email){
			$st = $pdo->prepare('UPDATE users_1 SET rights=:rights, user_name=:username, user_email=:user_email, password=:password, gender=:gender, city=:city WHERE id=:user_id');
			$st->bindValue(':user_email',$_POST['user_email']);
		}else{
			$st = $pdo->prepare('UPDATE users_1 SET rights=:rights, user_name=:username, password=:password, gender=:gender, city=:city WHERE id=:user_id');
		}
		$st->bindValue(':user_id',$_POST['user_id']);
		$st->bindValue(':username',$_POST['user_name']);
		if(!empty($_POST['password'])){
			if($_POST['password'] == $_POST['confirm_password']){
				$st->bindValue(':password',password_hash($_POST['password'],PASSWORD_DEFAULT));
			}else{
				$message = 'Password doesn\'t match';
				echo json_encode([
					'message' => $message,
					'check' => false
				]);
				die;
			}
		}else{
			$st->bindValue(':password',$user->password);
		}
		
		if(!empty($_POST['rs'])){
			$st->bindValue(':rights',implode(',',$_POST['rs']));
		}else{
			$st->bindValue(':rights','No rights');
		}
		$st->bindValue(':gender',$gender);
		$st->bindValue(':city',$city);
		$result = $st->execute();
		if($result){
			echo json_encode([
				'message' => 'records successfully updated',
				'check' => true
			]);
		}else{
			echo json_encode([
				'message' => 'something is wrong to update the data',
				'check' => false
			]);
		}

	}else{
		echo json_encode([
			'message' => 'something is wrong please try again latter',
			'check' => false
		]);
	}
}


function checkEmail($email = NULL,$user){
	global $pdo;
	if(filter_var($email,FILTER_VALIDATE_EMAIL)){
		$st = $pdo->prepare('SELECT * from users_1 WHERE user_email="'.$email.'"');
		$st->execute();
		$allUser = $st->fetch(PDO::FETCH_ASSOC);
		if(!empty($allUser)){
			echo json_encode([
			'check' => false,
			'message' => 'This not a valid email address please try again with something different'
		]);
		die;	
		}
		if($user->user_email == $_POST['user_email']){
			return false;
		}else{
			return true;
		}
	}else{
		echo json_encode([
			'check' => false,
			'message' => 'This not a valid email address please try again with something different'
		]);
		die;
	}
}

?>