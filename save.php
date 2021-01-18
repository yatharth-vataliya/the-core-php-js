<?php
session_start();
require_once("db.php");

//var_dump($_SERVER['REQUEST_METHOD']);
//die;

$sql = NULL;
/*echo "<pre>";
var_dump($_POST);
echo "</pre>";
die;*/
function checkData(...$data)
{
    global $is_ready;
    foreach ($data as $value):
        if (is_array($value)):
            foreach ($value as $val):
                if (empty($val)):
                    $is_ready = false;
                    $_SESSION['error'] = 'Please fill all fields';
                    return false;
                    break 2;
                else:

                endif;
            endforeach;
        else:
            if (empty($value)):
                $is_ready = false;
                $_SESSION['error'] = 'Please fill all fields';
                return false;
                break;
            else:

            endif;
        endif;
    endforeach;
    return true;
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['type'])) {
    if ($_POST['type'] == 'Save') {
        $sql = 'INSERT INTO users (username,userurl,useremail,funnel,password)VALUES(:username,:userurl,:funnel,:useremail,:password)';
    } elseif ($_POST['type'] == 'Update') {
        $sql = 'UPDATE users SET username = :username, userurl = :userurl, useremail = :useremail, funnel = :funnel, password = :password WHERE id = :user_id';
        if (empty($_POST['password'])) {
            $sql = 'UPDATE users SET username = :username, userurl = :userurl, useremail = :useremail, funnel = :funnel WHERE id = :user_id';
        }
    } else {
        $_SESSION['error'] = 'Bad request';
        return header("Location: prac_10.php");
    }
} else {
    $_SESSION['error'] = 'Sorry Bad request';
    return header("Location: prac_10.php");
}


$_SESSION['user_name'] = $username = $_POST['user_name'] ?? NULL;
$_SESSION['userurl'] = $userurl = $_POST['userurl'] ?? NULL;
$_SESSION['funnel'] = $funnel = $_POST['funnel'] ?? NULL;
$_SESSION['useremail'] = $useremail = $_POST['useremail'] ?? NULL;
$password = $_POST['password'] ?? NULL;
$confirm_password = $_POST['confirm_password'] ?? NULL;
$_SESSION['user_id'] = $user_id = $_POST['user_id'] ?? NULL;
$_SESSION['type'] = $_POST['type'];
$_SESSION['members'] = $members = $_POST['members'] ?? [];
$_SESSION['percentages'] = $percentages = $_POST['percentages'] ?? [];
$_SESSION['members_ids'] = $members_ids = $_POST['members_ids'] ?? [];

if ($_POST['type'] == 'Save') {
    $data = checkData($username, $userurl, $funnel, $useremail, $password, $confirm_password, $members, $percentages);
    if(!$data){
        return header('Location:'.$_SERVER['PHP_SELF']);
    }
    if ($password == $confirm_password) {

        $st = $pdo->prepare($sql);

        $st->bindValue(':username', $username);
        $st->bindValue(':userurl', $userurl);
        $st->bindValue(':funnel', $funnel);
        $st->bindValue(':useremail', $useremail);
        $st->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $st->execute();

        $id = $pdo->lastInsertId();
        $st = $pdo->prepare('INSERT INTO members (user_id,num_of_mem,percentage) VALUES (:userid,:nm,:per)');
        for ($i = 0; $i < count($members); $i++) {
            $st->bindValue(':userid', $id,PDO::PARAM_INT);
            $st->bindValue(':nm', $members[$i],PDO::PARAM_INT);
            $st->bindValue(':per', $percentages[$i],PDO::PARAM_INT);
            $st->execute();
        }
        session_unset();
        $_SESSION['info'] = 'All data are saved successfully into database';
        return header('Location: prac_10.php');
    } else {
        $_SESSION['error'] = 'Password does not  match';
        return header("Location: prac_10.php");
    }
} elseif ($_POST['type'] == 'Update') {
    $st = $pdo->prepare($sql);

    if (!empty($_POST['password'])) {
        $data = checkData($username, $userurl, $funnel, $useremail, $password, $confirm_password, $members, $percentages, $user_id);
        if($data == false){
            return header('Location: prac_10.php');
        }
        $st->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    } else {
        $data = checkData($username, $userurl, $funnel, $useremail, $members, $percentages, $user_id);
        if($data == false){
            return header('Location: prac_10.php');
        }
    }


    $st->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $st->bindValue(':username', $username);
    $st->bindValue(':userurl', $userurl);
    $st->bindValue(':funnel', $funnel);
    $st->bindValue(':useremail', $useremail);
    $st->execute();


    $ust = $pdo->prepare('SELECT id FROM members WHERE user_id = :user_id');
    $ust->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $ust->execute();
    $result = $ust->fetchAll(PDO::FETCH_CLASS);

    foreach($result as $res){
        if(!in_array($res->id,$members_ids)){
            $dmst = $pdo->prepare('DELETE FROM members WHERE id = :mem_id');
            $dmst->bindValue(':mem_id',$res->id,PDO::PARAM_INT);
            $dmst->execute();
        }
    }

    $imst = 'INSERT INTO members (user_id,num_of_mem,percentage) VALUES (:userid,:nm,:per)';
    $umst = 'UPDATE members SET num_of_mem = :nm, percentage = :per WHERE id = :mem_id';
    for ($i = 0; $i < count($members); $i++) {
        if (!empty($members_ids[$i])) {
            $st = $pdo->prepare($umst);
            $st->bindValue(':mem_id', $members_ids[$i], PDO::PARAM_INT);
        } else {
            $st = $pdo->prepare($imst);
            $st->bindValue(':userid', $user_id,PDO::PARAM_INT);
        }
        $st->bindValue(':nm', $members[$i],PDO::PARAM_INT);
        $st->bindValue(':per', $percentages[$i],PDO::PARAM_INT);
        $st->execute();
    }
    session_unset();
    $_SESSION['info'] = 'All data are saved successfully into database';
    return header('Location: prac_10.php');

} else {

}

?>