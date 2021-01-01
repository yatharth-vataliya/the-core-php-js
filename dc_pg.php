<?php

session_start();
require_once("db.php");
$page = $_GET['page'] ?? 1;
$row_count = (!empty($_GET['row_count'])) ? $_GET['row_count'] : 10;
$search = $_GET['search'] ?? NULL;

$st = $pdo->prepare("SELECT * FROM users_2 WHERE user_name LIKE :search OR (user_email LIKE :search) OR (mobile_no LIKE :search) OR (location LIKE :search)");
if(!empty($search)){
	$st->bindValue(':search','%'.$search.'%');
}else{
	$st->bindValue(':search','%%');
}
$st->execute();
$users = $st->fetchAll(PDO::FETCH_CLASS);

$total = count($users);
$total_pages = ceil($total / $row_count);
$offset = $row_count * ($page -1);

$sql = '';
if(!empty($search)){
	$sql = 'SELECT * FROM users_2 WHERE user_name LIKE :search OR (user_email LIKE :search) OR (mobile_no LIKE :search) OR (location LIKE :search) LIMIT :skip,:lim';
}else{
	$sql = 'SELECT * FROM users_2 LIMIT :skip,:lim';
}

$st = $pdo->prepare($sql);
if(!empty($search)){
	$st->bindValue(':search','%'.$search.'%');
}
$st->bindValue(':lim',$row_count,PDO::PARAM_INT);
$st->bindValue(':skip',$offset,PDO::PARAM_INT);
$st->execute();

$users = $st->fetchAll(PDO::FETCH_CLASS);
$no = 1;

echo json_encode([
	'page' => $page,
	'total' => $total,
	'total_pages' => $total_pages,
	'users' => $users
]);

/*
function getHTML($path = 'render.php')
{
    ob_start();
    include($path);
    $html=ob_get_contents(); 
    ob_end_clean();
    return $html;
}

echo json_encode([
	'html' => getHTML()
]);*/

?>