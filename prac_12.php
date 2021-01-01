<?php 
session_start();
require_once("db.php");

$st = $pdo->prepare("SELECT * FROM users_2");
$st->execute();
$users = $st->fetchAll(PDO::FETCH_CLASS);
$total = count($users);
$per_page = 10;
$total_pages = $total / 10;
$page = 6;
$no = 1;
$st = $pdo->prepare("SELECT * FROM users_2 LIMIT 10");
$st->execute();
$users = $st->fetchAll(PDO::FETCH_CLASS);
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="asset/css/all.css">
    <script src="asset/js/all.js" type="text/javascript"></script>

    <title>Prac 12</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row p-2">
            <div class="col-md-2 text-left">
                <input type="number" name="row_count" oninput="getTable();" id="row_count" class="form-control" placeholder="Per Page">
            </div>
            <div class="col-md-4 text-right">
                <input type="text" name="search" id="search" oninput="getTable();" class="form-control" placeholder="Search">
            </div>
            <div class="col-md-4">
                <button type="button" onclick="delM();" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <div id="dynamic_table">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Useremail</th>
                        <th>Mobile No</th>
                        <th>Location</th>
                        <th>Date</th>
                        <th><input type="checkbox" name="select_all" id="select_all" onchange="cState(this);"></th>
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
                            <td><input type="checkbox" name="deletes[]" value="<?php echo $user->id; ?>"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="p-2 alert alert-info">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group" id="links">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

        function getTable(page = 1){
            var search = document.getElementById("search").value;
            var row_count = document.getElementById("row_count").value;
            var http = new XMLHttpRequest();
            http.onreadystatechange = function(){
                if(this.readyState == 4 && this.status ==200){
                    response = JSON.parse(this.response);
                    // document.getElementById("dynamic_table").innerHTML = this.response;
                    var tds='';
                    users = response.users;
                    for(i = 0; i< users.length; i++){
                        tds +=`
                         <tr>
                            <td>${i + 1}</td>
                            <td>${users[i].user_name}</td>
                            <td>${users[i].user_email}</td>
                            <td>${users[i].mobile_no}</td>
                            <td>${users[i].location}</td>
                            <td>${users[i].date}</td>
                            <td><input type="checkbox" name="deletes[]" value="${users[i].id}"></td>
                        </tr>`;
                    }
                    var ll = '';
                    var rl = '';
                    page = response.page;
                    total_pages = response.total_pages;
                    for(i = 7; i >=0; i--){
                        if((parseInt(page) - i) <= 0) continue;
                        is_active = (parseInt(page) == (parseInt(page) - i)) ? 'active disabled' : '';
                        ll +=`<button type="button" onclick="getTable(${parseInt(page) - parseInt(i)})" class="btn btn-sm btn-outline-primary ${is_active}">${parseInt(page) - parseInt(i)}</button>`;
                    }
                    for(i = 1; i <=7; i++){
                        if((parseInt(page) + i) > total_pages) break;
                        is_active = (parseInt(page) == (parseInt(page) + i)) ? 'active disabled' : '';
                        ll +=`<button type="button" onclick="getTable(${parseInt(page) + parseInt(i)})" class="btn btn-sm btn-outline-primary ${is_active}">${parseInt(page) + parseInt(i)}</button>`;
                    }
                    document.getElementById('links').innerHTML = ll + rl;
                    document.getElementById('t_d').innerHTML = tds;

                }
            }
            http.open("GET",`dc_pg.php?row_count=${row_count}&search=${search}&page=${page}`,true);
            http.send();
        }
        getTable();

        function cState(chk){
            dlchk = document.getElementsByName('deletes[]');
            for(i = 0; i < dlchk.length; i++){
                dlchk[i].checked = chk.checked;
            }
        }

        function delM(){
            dlchk = document.getElementsByName('deletes[]');
            formData = new FormData();
            var val;
            for(i = 0; i < dlchk.length; i++){
                if(dlchk[i].checked){
                    formData.append('deletes[]',dlchk[i].value);
                }
            }

            var http = new XMLHttpRequest();
            http.onreadystatechange = function(){
                if(this.readyState == 4 && this.status ==200){
                    getTable();
                }
            }
            http.open("POST","delete_user2.php",true);
            http.send(formData);

        }

    </script>

</body>
</html>