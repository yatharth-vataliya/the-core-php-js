<?php

require_once "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['type'] == 'save') {
        $st = $pdo->prepare('INSERT INTO user_info (user_id,state,city) VALUES (:user_id,:state,:city)');
        $st->bindValue(":user_id", $_POST['user_id'], PDO::PARAM_INT);
        $st->bindValue(":state", $_POST['state']);
        $st->bindValue(":city", $_POST['city']);
        $result = $st->execute();

        if ($result) {
            echo json_encode([
                'check' => true,
                'message' => 'user info saved successfully'
            ]);
            return;
        } else {
            echo json_encode([
                'check' => false
            ]);
            return;
        }

    } elseif ($_POST['type'] == 'update') {
        $st = $pdo->prepare('UPDATE user_info SET state=:state, city=:city WHERE id=:userinfo_id');
        $st->bindValue(":state", $_POST['state'] ?? '--');
        $st->bindValue(":city", $_POST['city'] ?? '--');
        $st->bindValue(":userinfo_id", $_POST['userinfo_id'], PDO::PARAM_INT);
        $result = $st->execute();
        if ($result) {
            echo json_encode([
                'check' => true,
                'message' => 'User details successfully updated'
            ]);
            return;
        } else {
            echo json_encode([
                'check' => false,
                'message' => 'something went wrong please try again later'
            ]);
            return;
        }
    } elseif ($_POST['type'] == 'delete') {
        $st = $pdo->prepare('DELETE FROM user_info WHERE id=:userinfo_id');
        $st->bindValue(':userinfo_id', $_POST['userinfo_id'], PDO::PARAM_INT);
        $result = $st->execute();
        if ($result) {
            echo json_encode([
                'check' => true,
                'message' => 'User details Deleted'
            ]);
            return;
        } else {
            echo json_encode([
                'check' => false,
                'message' => 'something went wrong please try again later'
            ]);
            return;
        }
    } else {

    }
}

$table = 'user_info';

$primaryKey = 'id';

$columns = [
    ['db' => 'id', 'dt' => 'id'],
    ['db' => 'id', 'dt' => 'DT_rowId', 'formatter' => function ($d, $row) {
        return 'row_' . $d;
    }],
    ['db' => 'user_id', 'dt' => 'user_id'],
    ['db' => 'state', 'dt' => 'state'],
    ['db' => 'city', 'dt' => 'city']
];

$sql_details = [
    'user' => 'root',
    'pass' => 'rootroot',
    'db' => 'practice',
    'host' => 'localhost'
];

$whereAll = 'user_id = ' . $_GET['user_id'];
require_once "ssp.php";

echo json_encode(
    SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, $whereResult = null, $whereAll)
);
