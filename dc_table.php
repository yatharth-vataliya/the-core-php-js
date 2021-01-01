<?php 

require_once("db.php");


$st = $pdo->prepare("select * from users_1");
$st->execute();

$users = $st->fetchAll(PDO::FETCH_CLASS);
$no = 1;

?>

<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>No.</th>
			<th>Username</th>
			<th>Email</th>
			<th>Rights</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $user->user_name; ?></td>
				<td><?php echo $user->user_email; ?></td>
				<td><?php echo $user->rights; ?></td>
				<td>
					<button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button>
					<button type="button" class="btn btn-danger" onclick="deleteModal(<?php echo $user->id; ?>);"><i class="fas fa-trash"></i></button>
				</td>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>