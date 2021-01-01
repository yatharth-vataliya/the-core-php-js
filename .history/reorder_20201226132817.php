<?php

require_once("db.php");

if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['data_id'])){
    $st = $pdo->prepare('UPDATE sort_it SET order_id = :order_id WHERE id = :id');
    $result = false;
    for($i = 1; $i <= count($_POST['data_id']); $i++){
        $st->bindValue(':order_id',$i);
        $st->bindValue(':id',$_POST['data_id']['id']);
        $result = $st->execute();
    }
}