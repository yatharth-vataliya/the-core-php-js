<?php
session_start();
require_once "db.php";
require_once "helper.php";

$members = old('members') ?? [];
$percentages = old('percentages') ?? [];
$row_count = (count($members) >= 1) ? count($members) : 0;
$members_ids = old('members_ids') ?? [];

if (!empty($_GET['delete_id'])) {
    $dst = $pdo->prepare('DELETE FROM users WHERE id = :delete_id');
    $dst->bindValue(':delete_id', $_GET['delete_id'], PDO::PARAM_INT);
    $dst->execute();
    $dst = $pdo->prepare('DELETE FROM members WHERE user_id = :delete_id');
    $dst->bindValue(':delete_id', $_GET['delete_id'], PDO::PARAM_INT);
    $dst->execute();
    return header('Location: ' . $_SERVER['PHP_SELF']);
}

if(!empty($_GET['delete_mem_id'])){
    $mst = $pdo->prepare('DELETE FROM members WHERE id = :delete_mem_id');
    $mst->bindValue(':delete_mem_id',$_GET['delete_mem_id'],PDO::PARAM_INT);
    $mst->execute();
    return header('Location: '.$_SERVER['PHP_SELF'].'?user_id='.$_GET['user_id']);
}

if (!empty($_GET['user_id'])) {
    $ust = $pdo->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $ust->bindValue(':id', $_GET['user_id'], PDO::PARAM_INT);
    $ust->execute();
    $u_users = $ust->fetchAll(PDO::FETCH_OBJ);

    $mst = $pdo->prepare('SELECT * FROM members WHERE  user_id = :user_id');
    $mst->bindValue(':user_id', ((int)$u_users[0]->id), PDO::PARAM_INT);
    $mst->execute();
    $mems = $mst->fetchAll(PDO::FETCH_OBJ);
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
            <form id="save_form" method="POST" action="save.php">
                <input type="hidden" name="user_id" value="<?php echo old('user_id');
                echo (getVariable('u_users')[0]->id) ?? ''; ?>">
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
                    <?php for ($i = 0; $i < $row_count; $i++): ?>
                        <div id="row_<?php echo(1 + $i); ?>">
                            <input type="hidden" value="<?php echo ($members_ids[$i] ?? ''); ?>" name="members_ids[]">
                            <label for="members_<?php echo(1 + $i); ?>">Number of Members</label>
                            <input id="members_<?php echo(1 + $i); ?>" value="<?php echo $members[$i]; ?>" type="text"
                                   class="form-control" name="members[]">
                            <span style="display: none;color: red;" id="member_<?php echo(1 + $i); ?>">This field is required</span>

                            <label for="percentages_<?php echo(1 + $i); ?>">Percentage</label>
                            <input type="text" id="percentages_<?php echo(1 + $i); ?>"
                                   value="<?php echo $percentages[$i]; ?>" class="form-control" name="percentages[]">
                            <span style="display: none;color: red;" id="percentage_<?php echo(1 + $i); ?>">This field is required</span>

                            <button type="button" class="btn btn-danger"
                                    onclick="remove_row('row_<?php echo(1 + $i); ?>');">-
                            </button>
                        </div>
                    <?php endfor; ?>
                    <?php if (!empty($mems)): ?>
                        <?php $inc = 1;
                        foreach ($mems as $mem): ?>
                            <div id="row_<?php echo $inc; ?>">
                                <input type="hidden" value="<?php echo $mem->id; ?>" name="members_ids[]" >
                                <label for="members_<?php echo $inc; ?>">Number of Members</label>
                                <input id="members_<?php echo $inc; ?>" value="<?php echo $mem->num_of_mem; ?>"
                                       type="text"
                                       class="form-control" name="members[]">
                                <span style="display: none;color: red;" id="member_<?php echo $inc; ?>">This field is required</span>

                                <label for="percentages_<?php echo $inc; ?>">Percentage</label>
                                <input type="text" id="percentages_<?php echo $inc; ?>"
                                       value="<?php echo $mem->percentage; ?>" class="form-control"
                                       name="percentages[]">
                                <span style="display: none;color: red;" id="percentage_<?php echo $inc; ?>">This field is required</span>

                                <button type="button" class="btn btn-danger" onclick="remove_row('row_<?php echo $inc; ?>');">-</button>

                            </div>
                            <?php ++$inc; ?>
                        <?php endforeach; ?>
                        <?php $row_count = ($inc - 1); ?>
                    <?php endif; ?>
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
            <button type="button" onclick="addTextBox();" class="btn btn-success">+</button>
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

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var row_count = parseInt(<?php echo $row_count; ?>) + 1;
    var is_form_valid = false;

    function addTextBox() {
        /* text_box_html = `
         <div id="row_${row_count}">
         <label for="members_${row_count}">Number of Members</label><input id="members_${row_count}" type="text" class="form-control" name="members[]"><span style="display: none;color: red;" id="member_${row_count}">This field is required</span>
         <label for="percentages_${row_count}">Percentage</label><input type="text" id="percentages_${row_count}" class="form-control" name="percentages[]"><span style="display: none;color: red;" id="percentage_${row_count}">This field is required</span>
         <button type="button" class="btn btn-danger" onclick="remove_row('row_${row_count}');">-</button>
         </div>
         `;*/

        div = document.createElement('div');
        div.setAttribute('id', `row_${row_count}`)
        label1 = document.createElement('label');
        label1.setAttribute('for', `members_${row_count}`);
        label1.textContent = "Number of Members";
        input1 = document.createElement('input');
        input1.setAttribute('type', 'text');
        input1.setAttribute('id', `members_${row_count}`);
        input1.setAttribute('class', 'form-control');
        input1.setAttribute('name', 'members[]');


        div.appendChild(label1);
        div.appendChild(input1);

        label2 = document.createElement('label');
        label2.setAttribute('for', `percentages_${row_count}`);
        label2.textContent = "Percentage";
        input2 = document.createElement('input');
        input2.setAttribute('type', 'text');
        input2.setAttribute('id', `percentages_${row_count}`);
        input2.setAttribute('class', 'form-control');
        input2.setAttribute('name', 'percentages[]');

        div.appendChild(label2);
        div.appendChild(input2);

        rm_button = document.createElement('button');
        rm_button.setAttribute('type','button');
        rm_button.setAttribute('onclick',`remove_row('row_${row_count}')`);
        rm_button.className = 'btn btn-danger';
        rm_button.innerText = '-';

        div.appendChild(rm_button);

        dynamic_add_box = document.getElementById('add_text_box');
        dynamic_add_box.appendChild(div);

        row_count++;
    }

    function remove_row(row) {
        rw = document.getElementById(row);
        rw.remove();
    }

    function saveData() {
        username = document.getElementById("user_name");
        url = document.getElementById("userurl");
        funnel = document.getElementById("funnel");
        email = document.getElementById("useremail");
        password = document.getElementById("password");
        confirm_password = document.getElementById("confirm_password");
        m_number = document.getElementsByName("members[]");
        percentages = document.getElementsByName("percentages[]");
        if (m_number.length == percentages.length) {
            isEmpty(username);
            isEmpty(url);
            isEmpty(funnel);
            isEmpty(email);
            isEmpty(password);
            isEmpty(confirm_password);
            if (m_number.length >= 1) {
                isEmpty(m_number);
            }
            if (percentages.length >= 1) {
                isEmpty(percentages);
            }

            if (password.value !== confirm_password.value || password.value == '') {
                is_form_valid = false;
                password.nextSibling.style.innerHTML = "your password doesn't not match with confirm password";
                password.nextSibling.style.display = 'block';
            } else {
                is_form_valid = true;
                password.nextSibling.style.display = 'none';
            }

            if (is_form_valid) {
                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        document.getElementById("save_form").reset();
                        alert(response.message);
                    }
                }
                http.open("POST", "save.php", true);
                http.send(new FormData(document.getElementById('save_form')));
            } else {
                alert("something is wrong please check it first now");
            }

        } else {
            console.log("there something wrong in code");
        }
    }

    function isEmpty(data) {
        if (typeof data == 'object' && data.length >= 1) {
            for (i = 0; i < data.length; i++) {
                if (data[i].value == '' || data[i].value == NaN || data[i].value == null || data[i].value == " " || data[i].value == undefined) {
                    data[i].nextSibling.style.display = 'block';
                    is_form_valid = false;
                } else {
                    data[i].nextSibling.style.display = 'none';
                    is_form_valid = true;
                }
            }
        } else {
            if (data.value == '' || data.value == NaN || data.value == " " || data.value == null || data.value == undefined) {
                is_form_valid = false;
                data.nextSibling.style.display = 'block';
            } else {
                is_form_valid = true;
                data.nextSibling.style.display = 'none';
            }
        }
    }

    function cn() {
        document.getElementById('save_form').reset();
    }

</script>
</body>
</html>