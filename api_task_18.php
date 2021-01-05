<?php
require_once "db.php";

if ($_POST['want'] == 'parties') {
    echo json_encode([
        'parties' => getParties()
    ]);
    die;
}

if ($_POST['want'] == 'particular_parties' && !empty($_POST['state_id'])) {
    echo json_encode([
        'parties' => getParticularParties()
    ]);
    die;
}

if ($_POST['want'] == 'set_party' && !empty($_POST['state_id']) && !empty($_POST['party_ids'])) {
    $st = $pdo->prepare('UPDATE parties SET is_assigned = "yes", state_id = :state_id WHERE id = :party_id');
    $st->bindValue(':state_id', $_POST['state_id'], PDO::PARAM_INT);
    $result = false;
    foreach ($_POST['party_ids'] as $party_id) {
        $st->bindValue(':party_id', $party_id, PDO::PARAM_INT);
        $result = $st->execute();
    }
    if ($result) {
        echo json_encode([
            'message' => 'done successfully',
//            'parties' => getParticularParties()
        ]);
    } else {
        echo json_encode([
            'message' => 'something went wrong'
        ]);
    }
    die;
}

if ($_POST['want'] == 'reset_party' && !empty($_POST['party_ids'])) {
    $st = $pdo->prepare('UPDATE parties SET is_assigned = "no", state_id = NULL WHERE id = :party_id');
    $result = false;
    foreach ($_POST['party_ids'] as $party_id) {
        $st->bindValue(':party_id', $party_id);
        $result = $st->execute();
    }
    if ($result) {
        echo json_encode([
            'message' => 'done successfully',
//            'parties' => getParties()
        ]);
    } else {
        echo json_encode([
            'message' => 'something went wrong'
        ]);
    }
    die;
}

function getParties()
{
    global $pdo;
    $st = $pdo->query('SELECT * FROM parties WHERE is_assigned = "no"');
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    return $parties;
}

function getParticularParties()
{
    global $pdo;
    $st = $pdo->prepare('SELECT * FROM parties WHERE is_assigned = "yes" AND state_id = :state_id AND state_id IS NOT NULL');
    $st->bindValue(':state_id', $_POST['state_id'], PDO::PARAM_INT);
    $st->execute();
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    return $parties;
}

