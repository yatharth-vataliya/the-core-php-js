<?php

require_once("db.php");

var_dump($_POST);

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['data_id'])){
    $st = $pdo->prepare('UPDATE sort_it SET order_id = :order_id WHERE id = :id');
    $result = false;
    for($i = 0; $i < count($_POST['data_id']); $i++){
        $st->bindValue(':order_id',$i + 1);
        $st->bindValue(':id',$_POST['data_id'][$i]);
        $result = $st->execute();
    }
    if($result){
        echo json_encode([ 'message' => 'list ordering done successfully']);
    }else{
        echo json_encode(['message' => 'list ordering not done something went wrong please try again later']);
    }
}