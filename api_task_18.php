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

if ($_POST['want'] == 'set_party' && !empty($_POST['state_id']) && !empty($_POST['party_id'])) {
    $result = false;

    $st = $pdo->prepare('INSERT INTO set_party (party_id,state_id) VALUES (:party_id,:state_id)');
    $st->bindValue(':state_id', $_POST['state_id'], PDO::PARAM_INT);
    $st->bindValue(':party_id', $_POST['party_id'], PDO::PARAM_INT);
    $result = $st->execute();

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

if ($_POST['want'] == 'reset_party' && !empty($_POST['party_id'])) {

    $result = false;

    $st = $pdo->prepare('DELETE FROM set_party WHERE party_id = :party_id');
    $st->bindValue(':party_id', $_POST['party_id']);
    $result = $st->execute();

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
    $st = $pdo->query('SELECT parties.id as id, parties.party_name as party_name FROM parties LEFT OUTER JOIN set_party ON parties.id = set_party.party_id WHERE set_party.party_id IS NULL');
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    return $parties;
}

function getParticularParties()
{
    global $pdo;
//    $st = $pdo->prepare('SELECT * FROM parties WHERE is_assigned = "yes" AND state_id = :state_id AND state_id IS NOT NULL');
    $st = $pdo->prepare('SELECT parties.id as id, parties.party_name as party_name FROM set_party INNER JOIN parties ON set_party.party_id = parties.id WHERE set_party.state_id = :state_id');
    $st->bindValue(':state_id', $_POST['state_id'], PDO::PARAM_INT);
    $st->execute();
    $parties = $st->fetchAll(PDO::FETCH_OBJ);
    return $parties;
}

