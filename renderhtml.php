<?php 
session_start();
require_once("db.php");
$page = $_GET['page'] ?? 1;
$row_count = (!empty($_GET['row_count'])) ? $_GET['row_count'] : 10;
$search = $_GET['search'] ?? NULL;

$st = $pdo->prepare("SELECT * FROM users_2");
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

?>

<table class="table table-bordered table-hover table-striped">
	<thead>
		<tr>
			<th>No.</th>
			<th>Username</th>
			<th>Useremail</th>
			<th>Mobile No</th>
			<th>Location</th>
			<th>Date</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $user->user_name; ?></td>
				<td><?php echo $user->user_email; ?></td>
				<td><?php echo $user->mobile_no; ?></td>
				<td><?php echo $user->location; ?></td>
				<td><?php echo $user->date; ?></td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
<div class="p-2 alert alert-info">
	<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
		<div class="btn-group mr-2" role="group" aria-label="First group">
			<?php for($i = 7; $i >=0; $i--): ?>
				<?php if(($page - $i) <= 0) continue; ?>
				<button type="button" onclick="getTable(<?php echo ($page - $i); ?>);" class="btn btn-sm btn-outline-primary <?php echo ($page == ($page - $i)) ? 'active disabled' : ''; ?>">
					<?php echo ($page - $i); ?>
				</button>
			<?php endfor; ?>
			<?php for($i = 1; $i <= 7 ; $i++): ?>
				<?php if(($page + $i) > $total_pages) break; ?>
				<button type="button" onclick="getTable(<?php echo ($page + $i); ?>);" class="btn btn-sm btn-outline-primary <?php echo ($page == ($page + $i)) ? 'active disabled' : ''; ?>">
					<?php echo ($page + $i); ?>
				</button>
			<?php endfor; ?>
		</div>
	</div>
</div>