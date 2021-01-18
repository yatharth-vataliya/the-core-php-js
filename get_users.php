<?php 

/*require_once("db.php");

$st = $pdo->prepare("SELECT * FROM users_2");
$st->execute();
$users = $st->fetchAll(PDO::FETCH_OBJ);

$st = $pdo->prepare("SELECT * FROM users_2 LIMIT 10,10");
$st->execute();
$datas = $st->fetchAll(PDO::FETCH_OBJ);

$data = [];

foreach ($datas as $user) {
	$data[] = [
		$user->id,
		$user->user_name,
		$user->user_email,
		$user->mobile_no,
		$user->location,
		$user->date,
	];
}

echo json_encode([
	'draw' =>1,
	'recordsTotal' => count($users),
	'recordsFiltered' => 75,
	'data' => $data
]);
*/

?>

<?php 

$table = 'users_2';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	[ 'db' => 'id', 'dt' => 'id' ],
	[ 'db' => 'id', 'dt' => 'DT_rowId', 'formatter' => function($d,$row){ return 'row_'.$d; }],
	[ 'db' => 'user_name', 'dt' => 'user_name' ],
	[ 'db' => 'user_email',  'dt' => 'user_email' ],
	[ 'db' => 'mobile_no',   'dt' => 'mobile_no' ],
	[ 'db' => 'gender', 'dt' => 'gender'],
	[ 'db' => 'location',     'dt' => 'location' ],
	[ 'db' => 'date', 'dt' => 'date'],
	[ 'db' => 'image', 'dt' => 'image'],
);

// SQL server connection information
$sql_details = array(
	'user' => 'root',
	'pass' => 'rootroot',
	'db'   => 'practice',
	'host' => 'localhost'
);

require_once( 'ssp.php' );

echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);

?>