<?php

require_once("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['tb1_ids'])) {

    $result = false;
    $st = $pdo->prepare('UPDATE tabular_sorting SET tb1_order = :tb1_order, tb2_order = null WHERE id = :id');
    for ($i = 0; $i < count($_POST['tb1_ids']); $i++) {

        $id = null;
        if (!empty($_POST['tb1_names'][$i]) && ($_POST['tb1_names'][$i]) != 'null') {
            $st2 = $pdo->prepare('INSERT INTO tabular_sorting (name,tb1_order,tb2_order) VALUES (:name,:tb1_order,null)');
            $st2->bindValue(':name', $_POST['tb1_names'][$i] . time());
            $st2->bindValue(':tb1_order', $i + 1);
            $st2->execute();
            $id = $pdo->lastInsertId();
        }
        $st->bindValue(':tb1_order', $i + 1);
        $st->bindValue(':id', ($id ?? $_POST['tb1_ids'][$i]));
        $result = $st->execute();
    }

    $st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb1_order IS NOT NULL ORDER BY tb1_order ASC');
    $st->execute();
    $tb1 = $st->fetchAll(PDO::FETCH_OBJ);

    $st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb2_order IS NOT NULL ORDER BY tb2_order ASC');
    $st->execute();
    $tb2 = $st->fetchAll(PDO::FETCH_OBJ);

    if ($result) {
        echo json_encode(['message' => 'list ordering done successfully', 'tb1' => $tb1, 'tb2' => $tb2]);
    } else {
        echo json_encode(['message' => 'list ordering not done something went wrong please try again later', 'tb1' => $tb1]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['tb2_ids'])) {

    $result = false;
    $st = $pdo->prepare('UPDATE tabular_sorting SET tb2_order = :tb2_order, tb1_order = null WHERE id = :id');
    for ($i = 0; $i < count($_POST['tb2_ids']); $i++) {
        $id = null;
        if (!empty($_POST['tb2_names'][$i]) && ($_POST['tb2_names'][$i]) != 'null') {
            $st3 = $pdo->prepare('INSERT INTO tabular_sorting (name,tb2_order,tb1_order) VALUES (:name,:tb2_order,null)');
            $st3->bindValue(':name', $_POST['tb2_names'][$i] . time());
            $st3->bindValue(':tb2_order', $i + 1);
            $st3->execute();
            $id = $pdo->lastInsertId();
        }
        $st->bindValue(':tb2_order', $i + 1);
        $st->bindValue(':id', ($id ?? $_POST['tb2_ids'][$i]));
        $result = $st->execute();
    }

    $st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb1_order IS NOT NULL ORDER BY tb1_order ASC');
    $st->execute();
    $tb1 = $st->fetchAll(PDO::FETCH_OBJ);

    $st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb2_order IS NOT NULL ORDER BY tb2_order ASC');
    $st->execute();
    $tb2 = $st->fetchAll(PDO::FETCH_OBJ);

    if ($result) {
        echo json_encode(['message' => 'list ordering done successfully', 'tb1' => $tb1, 'tb2' => $tb2]);
    } else {
        echo json_encode(['message' => 'list ordering is not done something went wrong please try again later']);
    }
} else {
    echo json_encode(['message' => 'list ordering not done because of empty list']);
}