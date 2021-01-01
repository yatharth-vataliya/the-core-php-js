<?php
require_once("db.php");

$page = $_GET['page'] ?? 1;
$row_count = (!empty($_GET['row_count'])) ? $_GET['row_count'] : 10;
$search = $_GET['search'] ?? NULL;

$order_by = $_GET['order_by'] ?? 'id';

$ord = $_GET['order'] ?? 'ASC';
$order_string = "ORDER BY {$order_by} {$ord}";

$st = $pdo->prepare("SELECT * FROM users_2 WHERE user_name LIKE :search OR (user_email LIKE :search) OR (mobile_no LIKE :search) OR (location LIKE :search)");
if (!empty($search)) {
    $st->bindValue(':search', '%' . $search . '%');
} else {
    $st->bindValue(':search', '%%');
}
$st->execute();
$users = $st->fetchAll(PDO::FETCH_CLASS);

$total = count($users);
$total_pages = ceil($total / $row_count);
$offset = $row_count * ($page - 1);

if ($page > $total_pages) {
    if (!empty($total)) {
        header('location: prac_12_new.php?row_count=' . $row_count . '&search=' . ($_GET['search'] ?? '') . '&page=1&order_by=' . $order_by . '&order=' . $ord);
    }
}

if ($total < 0) {
    header('location: prac_12_new.php?row_count=' . $row_count . '&search=' . ($_GET['search'] ?? '') . '&page=1&order_by=' . $order_by . '&order=' . $ord);
}

$sql = '';
if (!empty($search)) {
    $sql = 'SELECT * FROM users_2 WHERE user_name LIKE :search OR (user_email LIKE :search) OR (mobile_no LIKE :search) OR (location LIKE :search) ' . $order_string . ' LIMIT :skip,:lim';
} else {
    $sql = 'SELECT * FROM users_2 ' . $order_string . ' LIMIT :skip,:lim ';
}

$st = $pdo->prepare($sql);
if (!empty($search)) {
    $st->bindValue(':search', '%' . $search . '%');
}
$st->bindValue(':lim', $row_count, PDO::PARAM_INT);
$st->bindValue(':skip', $offset, PDO::PARAM_INT);
$st->execute();
$users = $st->fetchAll(PDO::FETCH_CLASS);
$no = 1;


function getQueryString(): string
{
    global $row_count;
    return 'prac_12_new.php?row_count=' . $row_count . '&search=' . ($_GET['search'] ?? '') . '&page=' . ($_GET['page'] ?? 1);
}


function getLinks($page_number)
{
    global $row_count, $ord, $order_by;
    return 'prac_12_new.php?row_count=' . $row_count . '&search=' . ($_GET['search'] ?? '') . '&page=' . ($page_number) . '&order_by=' . $order_by . '&order=' . $ord;
}


?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="asset/css/all.css">
    <script src="asset/js/all.js" type="text/javascript"></script>

    <title>Prac 12 new one</title>
</head>
<body>

<div class="container-fluid">
    <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="page" value="<?php echo $_GET['page'] ?? 1; ?>">
        <input type="hidden" name="order_by" value="<?php echo $_GET['order_by'] ?? 'id'; ?>">
        <input type="hidden" name="order" value="<?php echo $ord ?? 'ASC'; ?>">
        <div class="row p-2">
            <div class="col-md-2 text-left">
                <input type="number" value="<?php echo $_GET['row_count'] ?? ''; ?>" name="row_count" id="row_count"
                       class="form-control"
                       placeholder="Per Page">
            </div>
            <div class="col-md-4 text-right">
                <input type="text" value="<?php echo $_GET['search'] ?? ''; ?>" name="search" id="search"
                       class="form-control"
                       placeholder="Search">
            </div>
            <div class="col-md-4">
                <input type="submit" class="btn btn-success" value="Search"/>
            </div>
            <div class="col-md-2">
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline-danger">Clear Filters</a>
            </div>
        </div>
    </form>
    <div id="dynamic_table">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>No.</th>
                <th>
                    <a href="<?php echo getQueryString(); ?>&order_by=user_name&order=<?php echo (!empty($_GET['order'])) ? ($_GET['order'] == 'ASC' ? 'DESC' : 'ASC') : 'ASC'; ?>">Username</a>
                </th>
                <th>
                    <a href="<?php echo getQueryString(); ?>&order_by=user_email&order=<?php echo (!empty($_GET['order'])) ? ($_GET['order'] == 'ASC' ? 'DESC' : 'ASC') : 'ASC'; ?>">Useremail</a>
                </th>
                <th>
                    <a href="<?php echo getQueryString(); ?>&order_by=mobile_no&order=<?php echo (!empty($_GET['order'])) ? ($_GET['order'] == 'ASC' ? 'DESC' : 'ASC') : 'ASC'; ?>">Mobile
                        no</a></th>
                <th>
                    <a href="<?php echo getQueryString(); ?>&order_by=location&order=<?php echo (!empty($_GET['order'])) ? ($_GET['order'] == 'ASC' ? 'DESC' : 'ASC') : 'ASC'; ?>">Location</a>
                </th>
                <th>
                    <a href="<?php echo getQueryString(); ?>&order_by=date&order=<?php echo (!empty($_GET['order'])) ? ($_GET['order'] == 'ASC' ? 'DESC' : 'ASC') : 'ASC'; ?>">Date</a>
                </th>
            </tr>
            </thead>
            <tbody id="t_d">
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
                <div class="btn-group mr-2" role="group" aria-label="First group" id="links">
                    <?php if ($total > 1): ?>
                        <?php if ($total_pages >= 1 && $page != 1): ?>
                            <a href="<?php echo getLinks(1); ?>"
                               class="btn btn-sm btn-outline-primary">First</a>
                        <?php else: ?>
                            <a href="<?php echo getLinks(1); ?>"
                               class="btn btn-sm btn-outline-primary disabled">First</a>
                        <?php endif; ?>
                        <?php if (($page - 1) <= 0 || $total_pages <= 0): ?>
                            <a href="#"
                               class="btn btn-sm btn-outline-primary disabled">Previous</a>
                        <?php else: ?>
                            <a href="<?php echo getLinks(($page - 1)); ?>"
                               class="btn btn-sm btn-outline-primary <?php echo (($page - 1) == $page) ? 'bg-danger text-white' : ''; ?>">Previous</a>
                        <?php endif; ?>
                        <?php for ($i = 7; $i >= 0; $i--): ?>
                            <?php if (($page - $i) <= 0) continue; ?>
                            <?php if (($page + $i) == $page): ?>
                                <a href="#"
                                   class="btn btn-sm btn-outline-primary <?php echo (($page - $i) == $page) ? 'bg-danger text-white' : ''; ?>"><?php echo($page - $i); ?></a>
                            <?php else: ?>
                                <a href="<?php echo getLinks(($page - $i)); ?>"
                                   class="btn btn-sm btn-outline-primary <?php echo (($page - $i) == $page) ? 'bg-danger text-white' : ''; ?>"><?php echo($page - $i); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <?php for ($i = 1; $i <= 7; $i++): ?>
                            <?php if (($page + $i) > $total_pages) continue; ?>
                            <?php if (($page + $i) == $page): ?>
                                <a href="#"
                                   class="btn btn-sm btn-outline-primary <?php echo (($page + $i) == $page) ? 'bg-success text-white' : ''; ?>"><?php echo($page + $i); ?></a>
                            <?php else: ?>
                                <a href="<?php echo getLinks(($page + $i)); ?>"
                                   class="btn btn-sm btn-outline-primary <?php echo (($page + $i) == $page) ? 'bg-danger disabled text-white' : ''; ?>"><?php echo($page + $i); ?></a>
                            <?php endif; ?>

                        <?php endfor; ?>
                        <?php if ($page < $total_pages): ?>
                            <a href="<?php echo getLinks($page + 1); ?>"
                               class="btn btn-sm btn-outline-primary">Next</a>
                        <?php else: ?>
                            <a href="<?php echo getLinks(1); ?>"
                               class="btn btn-sm btn-outline-primary disabled">Next</a>
                        <?php endif; ?>
                        <?php if (($page != $total_pages) && ($page < $total_pages)): ?>
                            <a href="<?php echo getLinks(($total_pages)); ?>"
                               class="btn btn-sm btn-outline-primary">Last</a>
                        <?php else: ?>
                            <a href="#"
                               class="btn btn-sm btn-outline-primary disabled">Last</a>
                        <?php endif; ?>
                    <?php else: ?>
                        No records found please search with different parameters
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>