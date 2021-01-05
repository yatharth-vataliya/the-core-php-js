<?php
require_once "db.php";

if ($_POST['want'] == 'parties') {
    $st = $pdo->query('SELECT * FROM parties WHERE is_assigned = "no"');
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    echo json_encode([
        'parties' => $parties
    ]);
    die;
}

if ($_POST['want'] == 'particular_parties' && !empty($_POST['state_id'])) {
    $st = $pdo->prepare('SELECT * FROM parties WHERE is_assigned = "yes" AND state_id = :state_id');
    $st->bindValue(':state_id', $_POST['state_id'], PDO::PARAM_INT);
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    echo json_encode([
        'parties' => $parties
    ]);
    die;
}

if ($_POST['want'] == 'set_party') {
    $st = $pdo->prepare('UPDATE parties SET is_');
}