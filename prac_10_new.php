<?php
session_start();
require_once "db.php";
require_once "helper.php";

$main = $members = old('members') ?? [];
$percentages = old('percentages') ?? [];
$update_members_ids = old('update_members_ids') ?? '';
$delete_members_ids = old('delete_members_ids') ?? '';

if (!empty($_GET['delete_id'])) {
    $dst = $pdo->prepare('DELETE FROM users WHERE id = :delete_id');
    $dst->bindValue(':delete_id', $_GET['delete_id'], PDO::PARAM_INT);
    $dst->execute();
    $dst = $pdo->prepare('DELETE FROM members WHERE user_id = :delete_id');
    $dst->bindValue(':delete_id', $_GET['delete_id'], PDO::PARAM_INT);
    $dst->execute();
    return header('Location: ' . $_SERVER['PHP_SELF']);
}


if (!empty($_GET['user_id'])) {
    $ust = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $ust->bindValue(':id', $_GET['user_id'], PDO::PARAM_INT);
    $ust->execute();
    $u_users = $ust->fetchAll(PDO::FETCH_OBJ);

    $mst = $pdo->prepare('SELECT * FROM members WHERE  user_id = :user_id');
    $mst->bindValue(':user_id', ((int)$u_users[0]->id), PDO::PARAM_INT);
    $mst->execute();
    $main = $mems = $mst->fetchAll(PDO::FETCH_OBJ);
}

$st = $pdo->query('SELECT * FROM users');
$users = $st->fetchAll(PDO::FETCH_OBJ);


function getVariable($variable_name)
{
    global ${$variable_name};
    if (!empty(${$variable_name})) {
        return ${$variable_name};
    } else {
        return NULL;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Prac 10</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/all.css">
    <script src="asset/js/all.js"></script>
</head>
<body>

<div class="container-fluid">
    <?php $error = old('error');
    if (!empty($error)): ?>
        <div class="alert alert-danger shadow m-1">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php $info = old('info');
    if (!empty($info)): ?>
        <div class="alert alert-info shadow m-1">
            <?php echo $info; ?>
        </div>
    <?php endif; ?>
</div>

<div class="container-fluid">
    <div class="row p-2">
        <div class="col-md-5">
            <form id="save_form" method="POST" action="save_10.php">

                <input type="hidden" name="user_id" value="<?php echo old('user_id');
                echo (getVariable('u_users')[0]->id) ?? ''; ?>">
                <input type="hidden" name="update_members_ids" value="" id="update_members_ids"
                       style="display: none;">
                <input type="hidden" name="delete_members_ids" value="" id="delete_members_ids"
                       style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <lable for="user_name">User Name</lable>
                        <input type="text" name="user_name" id="user_name" class="form-control"
                               placeholder="User Name" value="<?php echo old('user_name');
                        echo (getVariable('u_users')[0]->username) ?? ''; ?>"/>
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <lable for="useremail">User Email</lable>
                        <input type="text" name="useremail" id="useremail" class="form-control"
                               placeholder="User Email" value="<?php echo old('useremail');
                        echo (getVariable('u_users')[0]->useremail) ?? ''; ?>"/>
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <lable for="userurl">User Url</lable>
                        <input type="text" name="userurl" id="userurl" class="form-control"
                               value="<?php echo old('userurl');
                               echo (getVariable('u_users')[0]->userurl) ?? ''; ?>" placeholder="User Url">
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <lable for="funnel">User Funnel</lable>
                        <input type="text" name="funnel" id="funnel" class="form-control"
                               value="<?php echo old('funnel');
                               echo (getVariable('u_users')[0]->funnel) ?? ''; ?>" placeholder="Funnel">
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <lable for="password">Password</lable>
                        <input type="password" class="form-control" name="password" id="password"
                               placeholder="Password">
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <lable for="confirm_password">Confirm password</lable>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                               placeholder="Confrim Password">
                        <span style="display:none;color:red;">This Field is required</span>
                    </div>
                </div>
                <div id="add_text_box" class="col-md-12">

                </div>
                <div class="row p-2">
                    <div class="col-md-12">
                        <input type="submit" name="type"
                               value="<?php echo(old('type') ?? (!empty($_GET['user_id']) ? 'Update' : 'Save')); ?>"
                               class="btn btn-outline-success">
                        <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="btn btn-outline-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1">
            <button type="button" onclick="addFields();" class="btn btn-success">+</button>
        </div>
        <div class="col-md-6">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>user Url</th>
                    <th>User funnel</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody class="text-break">
                <?php $no = 1;
                foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $user->username; ?></td>
                        <td><?php echo $user->useremail; ?></td>
                        <td><?php echo $user->userurl; ?></td>
                        <td><?php echo $user->funnel; ?></td>
                        <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?user_id=' . $user->id; ?>"
                               class="btn btn-warning"><i class="fas fa-edit"></i></a></td>
                        <td><a href="<?php echo $_SERVER['PHP_SELF'] . '?delete_id=' . $user->id; ?>"
                               class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="" style="display: none;" class="clone_div">
    <label for="">Number of Members</label>
    <input id="member_id" type="text" class="form-control" name="members[]">
    <label for="">Percentage</label>
    <input type="text" id="percentage_id" class="form-control" name="percentages[]">
    <button type="button" class="btn btn-danger">-</button>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>

    var row_count = 1;
    var div_clone = document.getElementsByClassName('clone_div');
    var add_text_box = document.getElementById('add_text_box');
    var save_form = document.getElementById('save_form');
    var update_input_clone = document.getElementsByClassName('clone_update_input');
    var delete_input_clone = document.getElementsByClassName('clone_delete_input');
    var main = <?php echo json_encode($main); ?>;
    var percentages = <?php echo json_encode($percentages); ?>;
    var update_members_ids = <?php echo json_encode($update_members_ids); ?>;
    var delete_members_ids = <?php echo json_encode($delete_members_ids) ?>;

    function addFields(mem = null) {
        num = null;
        per = null;
        if (mem != null) {
            // console.log(mem);
            num = mem.num_of_mem;
            per = mem.percentage;
            update_ids = document.getElementById('update_members_ids');
            if(mem.id != null && mem.id != ''){
                update_ids.value += `${mem.id},`;
            }
        }

        clone = div_clone[0].cloneNode(true);

        clone.setAttribute('class', '');
        clone.setAttribute('id', `row_${row_count}`);
        clone.children[0].setAttribute('for', `member_${row_count}`);
        clone.children[1].setAttribute('id', `member_${row_count}`);
        if (num != null && num != '') {
            clone.children[1].setAttribute('value', `${num}`);
            num = '';
        }
        clone.children[2].setAttribute('for', `percentage_${row_count}`);
        clone.children[3].setAttribute('id', `percentage_${row_count}`);
        if (per != null && per != '') {
            clone.children[3].setAttribute('value', `${per}`);
            per = '';
        }
        if (mem != null && mem != '') {
            clone.children[4].classList.add(`row_${row_count}`);
            if(mem.id != null && mem.id != ''){
                clone.children[4].classList.add(`${mem.id}`);
            }

        } else {
            clone.children[4].classList.add(`row_${row_count}`);
        }
        clone.style.display = 'block';
        add_text_box.appendChild(clone);
        getDeleteButtons();
        row_count++;
    }

    function remove_row(row_id = null, mem_delete_id = null) {
        if (mem_delete_id != null && mem_delete_id != '') {
            u_ids = document.getElementById('update_members_ids');
            uds = u_ids.value.replace(`${mem_delete_id}`,' ');
            u_ids.value = uds;
            d_ids = document.getElementById('delete_members_ids');
            d_ids.value += `${mem_delete_id},`;
        }
        dl_element = document.getElementById(row_id);
        if (row_id != null) {
            dl_element.remove();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        generateFields();
        getDeleteButtons();
    });

    function getDeleteButtons() {
        buttons = document.querySelectorAll("button[class*='row']");
        for (i = 0; i < buttons.length; i++) {
            class_names = buttons[i].classList;
            // console.table(class_names);
            index = class_names.length - 2;
            index1 = class_names.length - 1;
            if (class_names[index] != null && class_names[index1] != null) {
                if (class_names[index].includes('row_')) {
                    buttons[i].setAttribute('onclick', `remove_row('${class_names[index]}',${class_names[index1]})`);
                } else {
                    buttons[i].setAttribute('onclick', `remove_row('${class_names[index1]}')`);
                }
            } else if (class_names[index1] != null) {
                buttons[i].setAttribute('onclick', `remove_row('${class_names[index1]}')`);
            } else {

            }
        }
    }

    function generateFields() {
        u_ids = update_members_ids.split(',');
        d_ids = delete_members_ids.split(',');
        temp_u = [];
        for(u = 0; u < u_ids.length; u++){
            if(u_ids[u] != '' && u_ids[u] != null && u_ids[u] != ' '){
                temp_u.push(u_ids[u]);
            }
        }
        temp_d = [];
        for(d = 0; d < d_ids.length; d++){
            if(d_ids[d] != '' && d_ids[d] != null && d_ids[d] != ' '){
                temp_d.push(d_ids[d]);
            }
        }
        u_ids = temp_u;
        d_ids = temp_d;
        // debugger;
        if (main != null) {
            for (j = 0; j < main.length; j++) {
                if (main[j].id != null && main[j].id != '') {
                    addFields(main[j]);
                } else if (u_ids[j] != null) {
                    addFields({"id": u_ids[j], "num_of_mem": main[j], "percentage": percentages[j]});
                } else {
                    addFields({"id": '', "num_of_mem": main[j], "percentage": percentages[j]});
                }
                if (d_ids[j] != null && d_ids[j] != undefined) {
                    if(d_ids[j] != undefined && d_ids[j] != ''){
                        remove_row(null, d_ids[j]);
                    }
                }
            }
        } else {

        }
    }

</script>
</body>
</html>
