<?php 
session_start();
require_once("db.php");
require_once("helper.php");
$st = $pdo->prepare("SELECT * FROM users_1 WHERE status='active'");
$st->execute();

$users = $st->fetchAll(PDO::FETCH_CLASS);
$no = 1;
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

    <title>Prac 11</title>
</head>
<body>
    <div class="container-fluid">
        <?php if (!empty($_SESSION['errors'])): ?>
        <?php foreach($_SESSION['errors'] as $key => $error): ?>
            <div class="alert alert-danger shadow m-2">
                <?php echo $error;?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
        <?php endif ?>
        <?php if (!empty($_SESSION['info'])): ?>
            <div class="alert alert-info shadow m-2">
                <?php echo $_SESSION['info'];?>
            </div>
        <?php unset($_SESSION['info']); ?>
        <?php endif ?>
    </div>
    <div class="container-fluid bg-white">
       <form id="sub_admin_form" method="POST" action="save1.php">
        <input type="hidden" value="<?php echo old('user_id'); ?>" id="user_id" name="user_id">
        <div class="row p-2">
            <div class="col-md-4">
                Name
            </div>
            <div class="col-md-4">
                <input type="text" name="user_name" value="<?php echo old('user_name'); ?>" id="user_name" class="form-control">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                Email
            </div>
            <div class="col-md-4">
                <input type="email" name="user_email" value="<?php echo old('user_email'); ?>" id="user_email" class="form-control">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                Gender
            </div>
            <div class="col-md-4">
                <?php $gender = old('gender'); ?>
                <input type="radio" name="gender" id="male" value="male" <?php echo ($gender == 'male') ? 'checked' : ''; ?>>
                Male
                <input type="radio" name="gender" id="female" value="female" <?php echo ($gender == 'female') ? 'checked' : ''; ?>>
                Female
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                City
            </div>
            <div class="col-md-4">
                <select name="city" id="city" class="custom-select">
                    <?php $city = old('city'); ?>
                    <option selected disabled="">--Please Select Any City--</option>
                    <option value="Rajkot" <?php echo ($city == 'Rajkot') ? 'selected' : ''; ?>>Rajkot</option>
                    <option value="Jamnagar" <?php echo ($city == 'Jamnagar') ? 'selected' : ''; ?>>Jamnagar</option>
                    <option value="Surat" <?php echo ($city == 'Surat') ? 'selected' : ''; ?>>Surat</option>
                    <option value="Baroda" <?php echo ($city == 'Baroda') ? 'selected' : ''; ?>>Baroda</option>
                </select>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                Password
            </div>
            <div class="col-md-4">
                <input type="password" name="password" id="password" class="form-control">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                Confirm Password
            </div>
            <div class="col-md-4">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-4">
                Assign Rights
            </div>
            <div class="col-md-4">
                <?php $rights = old('rights') ?? []; ?>
                <input type="checkbox" name="rights[]" value="Dashboard" <?php echo (in_array('Dashboard',$rights) ? 'checked' : '');?>> Dashboard<br/>
                <input type="checkbox" name="rights[]" value="Provider List" <?php echo (in_array('Provider List',$rights) ? 'checked' : '');?>> Provider List<br/>
                <input type="checkbox" name="rights[]" value="Customer List" <?php echo (in_array('Customer List',$rights) ? 'checked' : '');?>> Customer List<br/>
                <input type="checkbox" name="rights[]" value="Job List" <?php echo (in_array('Job List',$rights) ? 'checked' : '');?>> Job List<br/>
                <input type="checkbox" name="rights[]" value="Reviews" <?php echo (in_array('Reviews',$rights) ? 'checked' : '');?>> Reviews<br/>
                <input type="checkbox" name="rights[]" value="Complaint List" <?php echo (in_array('Complaint List',$rights) ? 'checked' : '');?>> Complaint List<br/>
                <input type="checkbox" name="rights[]" value="Provider Apporval List" <?php echo (in_array('Provider Apporval List',$rights) ? 'checked' : ''); ?>> Provider Approval List<br/>
                <input type="checkbox" name="rights[]" value="Needs Approval" <?php echo (in_array('Needs Approval',$rights) ? 'checked' : '');?>> Needs Approval<br/>
                <input type="checkbox" name="rights[]" value="Provider Approved" <?php echo (in_array('Provider Approved',$rights) ? 'checked' : '');?>> Provider Approved<br/>
                <input type="checkbox" name="rights[]" value="Faq List" <?php echo (in_array('Faq List',$rights) ? 'checked' : '');?>> Faq List<br/>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-6">
                <input type="submit" name="submit" id="submit" value="<?php echo old('submit') ?? 'save'; ?>" class="btn btn-primary">
            </div>
        </div>
    </form>
    <div class="text-right mt-3">
        <button type="button" onclick="subAdminModal();" class="btn btn-info shadow-sm">Add Sub Admin</button>
    </div>
    <div class="row">
        <div class="col-md-12" id="dc_table">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Rights</th>
                        <th>Gender</th>
                        <th>City</th>
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
                            <td><?php echo $user->gender; ?></td>
                            <td><?php echo $user->city; ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" onclick="editUser(<?php echo $user->id; ?>);"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="deleteModal(<?php echo $user->id; ?>);"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- add sub admin modal -->

<div class="modal fade" id="subAdminModal" tabindex="-1" aria-labelledby="subAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="subAdminModalLabel">Add Sub Admin Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
       <!--  <form id="sub_admin_form" onsubmit="evenet.preventDefault();">
            <input type="hidden" value="" id="user_id" name="user_id">
            <div class="row p-2">
                <div class="col-md-4">
                    Name
                </div>
                <div class="col-md-4">
                    <input type="text" name="user_name" id="user_name" class="form-control">
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    Email
                </div>
                <div class="col-md-4">
                    <input type="email" name="user_email" id="user_email" class="form-control">
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    Gender
                </div>
                <div class="col-md-4">
                    <input type="radio" name="gender" id="male" value="male">
                    Male
                    <input type="radio" name="gender" id="female" value="female">
                    Female
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    City
                </div>
                <div class="col-md-4">
                    <select name="city" id="city" class="custom-select">
                        <option selected disabled="">--Please Select Any City--</option>
                        <option value="Rajkot">Rajkot</option>
                        <option value="Jamnagar">Jamnagar</option>
                        <option value="Surat">Surat</option>
                        <option value="Baroda">Baroda</option>
                    </select>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    Password
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    Confirm Password
                </div>
                <div class="col-md-4">
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>
            </div>
            <div class="row p-2">
                <div class="col-md-4">
                    Assign Rights
                </div>
                <div class="col-md-4">
                    <input type="checkbox" name="rights[]" value="Dashboard"> Dashboard<br/>
                    <input type="checkbox" name="rights[]" value="Provider List"> Provider List<br/>
                    <input type="checkbox" name="rights[]" value="Customer List"> Customer List<br/>
                    <input type="checkbox" name="rights[]" value="Job List"> Job List<br/>
                    <input type="checkbox" name="rights[]" value="Reviews"> Reviews<br/>
                    <input type="checkbox" name="rights[]" value="Complaint List"> Complaint List<br/>
                    <input type="checkbox" name="rights[]" value="Provider Apporval List"> Provider Approval List<br/>
                    <input type="checkbox" name="rights[]" value="Needs Approval"> Needs Approval<br/>
                    <input type="checkbox" name="rights[]" value="Provider Approved"> Provider Approved<br/>
                    <input type="checkbox" name="rights[]" value="Faq List"> Faq List<br/>
                </div>
            </div>
        </form> -->
        <div class="text-left">
            <!-- <input type="submit" name="submit" id="submit" value="save" class="btn btn-primary" onclick="gotoData();"> -->
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
</div>

<!-- delete modal -->

<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Confirm Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete user ?
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="deleteUser();">Yes, Delete</button>
    </div>
</div>
</div>
</div>

<!-- Edit Modal -->

<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Update Admin  Rights</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
      <div class="modal-body" >
        <form action="" id="update_rights" method="POST" accept-charset="utf-8">

        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" onclick="updateUser();">Update</button>
    </div>
</div>
</div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function subAdminModal(){
        document.getElementById('submit').value = 'save';
        document.getElementById('sub_admin_form').reset();
    // $("#subAdminModal").modal("show");
}
function reload_table(){
    var http = new XMLHttpRequest();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            response = JSON.parse(this.response);
            document.getElementById('dc_table').innerHTML = response.html;
        }
    }
    http.open("POST","dynamic_table.php",true);
    http.send();
}

function saveData(){
    var http = new XMLHttpRequest();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            response = JSON.parse(this.response);
            document.getElementById("sub_admin_form").reset();
            if(response.check){
                $("#subAdminModal").modal("hide");
                reload_table();
                alert(response.message);
            }else{
                alert(response.message);
            }
        }
    }
    http.open("POST","save1.php",true);
    save_form = new FormData(document.getElementById('sub_admin_form'));
    save_form.append('submit','save');
    http.send(save_form);
    reload_table();
}
var delete_user_id = null;
function deleteModal(user_id){
    delete_user_id = user_id;
    $("#deleteModal").modal("show");
}

function deleteUser(){
    var http = new XMLHttpRequest();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            response = JSON.parse(this.response);
            $("#deleteModal").modal("hide");
            reload_table();
        }
    }
    http.open("POST","delete_user.php",true);
    form = new FormData();
    form.append('user_id',delete_user_id);
    http.send(form);

    delete_user_id = null;
}

function editUser(user_id){
    var http = new XMLHttpRequest();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            response = JSON.parse(this.response);
            // document.getElementById("update_rights").innerHTML = response.html;
            user = response.user;
            document.getElementById('user_name').value = user.user_name;
            document.getElementById('user_email').value = user.user_email;
            gender = user.gender;
            (gender == 'male') ? document.getElementById('male').checked = true : document.getElementById('female').checked = true;
            document.getElementById('user_id').value = user.id;
            document.getElementById('city').value = user.city;
            rights = document.getElementsByName('rights[]');
            var drights = user.rights.split(",");
            for(i = 0; i < rights.length; i++){
                rights[i].checked = false;
            }
            for(i = 0; i < rights.length; i++){
                for(j = 0; j<drights.length; j++){
                    if(rights[i].defaultValue == drights[j]){
                        rights[i].checked = true;
                    }
                }                        
            }
            document.getElementById("submit").value = "update";
            // $("#subAdminModal").modal('show');
        }
    }
    http.open("POST","edit_user.php",true);
    form = new FormData();
    form.append('user_id',user_id);
    form.append('type','edit');
    http.send(form);
}


function updateUser(){
    form = new FormData(document.getElementById('sub_admin_form'));

    var http = new XMLHttpRequest();
    http.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            response = JSON.parse(this.response);
            if(response.check){
                alert(response.message);
                $("#subAdminModal").modal('hide');
                reload_table();
                document.getElementById('sub_admin_form').reset();
            }else{
                alert(response.message);
            }
        }
    }
    http.open("POST","save1.php",true);
    form.append('submit','update');
    http.send(form);

}

function gotoData(){
    res = document.getElementById("submit").value;
    if(res == 'save'){
        saveData();
    }else{
        updateUser();
    }
}



</script>

</body>
</html>