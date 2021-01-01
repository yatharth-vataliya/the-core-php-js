<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

  <link rel="stylesheet" type="text/css" href="asset/css/all.css">

  <title>Prac 15</title>
</head>
<body>

  <div class="container-fluid">
    <table id="tb1" class="table table-bordered table-hover table-striped">
      <thead>
        <tr>
          <th>Username</th>
          <th>Useremail</th>
          <th>Mobile No</th>
          <th>Gender</th>
          <th>Location</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Username</td>
          <td>Useremail</td>
          <td>Mobile No</td>
          <td>Gender</td>
          <td>Location</td>
          <td>Date</td>
          <td>Action</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- View User Data -->


<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewModalLabel">User Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="user_form">
          <input type="hidden" value="" id="user_id" name="user_id">
          <div class="row p-2">
            <div class="col">
              <label class="form-control-label" for="user_name">Username</label>
              <input type="text" id="user_name" name="user_name" class="form-control" placeholder="user_name">
            </div>
             <div class="col">
              <label class="form-control-label" for="user_email">Useremail</label>
              <input type="email" id="user_email" name="user_email" class="form-control" placeholder="Useremail">
            </div>
             <div class="col">
              <label class="form-control-label" for="mobile_no">Mobile No</label>
              <input type="number" id="mobile_no" name="mobile_no" class="form-control" placeholder="Mobile No">
            </div>
          </div>
          <div class="row p-2">
            <div class="col">
              <label class="form-control-label" for="location">Location</label>
              <input type="text" id="location" name="location" class="form-control" placeholder="Location">
            </div>
            <div class="col">
              <label class="form-control-label" for="date">Date</label>
              <input type="date" id="date" name="date" class="form-control" placeholder="Date">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="button" id="submit_button" onclick="saveData();" value="save" style="display: none;" class="btn btn-primary">
      </div>
    </div>
  </div>
</div>



  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script src="asset/js/all.js" type="text/javascript"></script>

  <script>
    var number = 1;
    var t = null;
    $(document).ready( function () {
      t = $('#tb1').DataTable({
        'processing' : true,
        'serverSide' : true,
        'ajax' : 'get_users.php',
        'order': [],
        columnDefs: [
          { orderable: false, "targets": 2 },
          { searchable : false, "targets": 2}
        ],
        'columns':[
      // {'data' : 'id'},
      {'data': 'user_name'},
      {'data': 'user_email'},
      {'data': 'mobile_no'},
      {
        'data': 'gender',
        render : function(data,type,row,meta){
          return `
          Female <input type="radio" value="female" onclick="updateGender(${row.id},'femaile')" name="gender_${row.id}" ${data == 'female' ? 'checked' : ''}> 
          Male <input type="radio" value="male" onclick="" name="gender_${row.id}" ${data == 'male' ? 'checked' : ''}>`;
        }
      },
      {'data': 'location'},
      {'data': 'date'},
      {
        'data': '',
        render: function(data,type,row,meta){
          return `<button type="button" class="btn btn-info btn-sm" onclick="viewUser(this)"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-warning btn-sm" onclick="editUser(this)"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-sm" onclick="deleteUser(this)"><i class="fas fa-trash"></i></button>`;
        }
      }]
    });

    });

    var user_name = document.getElementById('user_name');
    var user_email = document.getElementById('user_email');
    var mobile_no = document.getElementById('mobile_no');
    var loation = document.getElementById('location');
    var date = document.getElementById('date');
    var submit_button = document.getElementById('submit_button');
    function viewUser(user_id){
      user = t.row(user_id.parentElement.parentElement).data();
      user_name.value = user.user_name;
      user_email.value = user.user_email;
      mobile_no.value = user.mobile_no;
      loation.value = user.location;
      odate = new Date(user.date);
      month = ((odate.getMonth() + 1) < 10) ? `0${odate.getMonth() + 1}` : (odate.getMonth() + 1);
      cdate = `${odate.getFullYear()}-${month}-${odate.getDate()}`;
      date.value = cdate;
      $("#viewModal").modal('show');
    }

    function editUser(user_id){

      user = t.row(user_id.parentElement.parentElement).data();
      document.getElementById('user_id').value = user.id;
      user_name.value = user.user_name;
      user_email.value = user.user_email;
      mobile_no.value = user.mobile_no;
      loation.value = user.location;
      odate = new Date(user.date);
      month = ((odate.getMonth() + 1) < 10) ? `0${odate.getMonth() + 1}` : (odate.getMonth() + 1);
      cdate = `${odate.getFullYear()}-${month}-${odate.getDate()}`;
      date.value = cdate;
      submit_button.value = 'update';
      submit_button.style.display = 'block';
      $("#viewModal").modal('show');

      /*user = t.row(user_id.parentElement.parentElement).data();
      child =  user_id.parentElement.parentElement.childNodes;
      child[1].innerHTML = 'yatharth@gmail.com';
      user.user_email = 'yatharth@gmail.com';*/
    }

    function saveData(){
      switch (submit_button.value) {
        case 'save':
          // statements_1
          break;
        case 'update':
          var http = new XMLHttpRequest();
          http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                response = JSON.parse(this.response);
                alert(response.message);
            }
          }
          http.open("POST","users2api.php",false);
          formData = new FormData(document.getElementById('user_form'));
          formData.append('type','update');
          http.send(formData);
          t.ajax.reload();
          $("#viewModal").modal('hide');
          break;
        default:
          // statements_def
          break;
      }
    }

    function deleteUser(user_id){
      user = t.row(user_id.parentElement.parentElement).data();
      conf = confirm("are you sure you want to delete this user ? this can't be revert");
      if(conf){
        var http = new XMLHttpRequest();
          http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                response = JSON.parse(this.response);
                alert(response.message);
            }
          }
          http.open("POST","users2api.php",false);
          formData = new FormData();
          formData.append('user_id',user.id);
          formData.append('type','delete');
          http.send(formData);
          t.ajax.reload();
      }
    }

    $('#tb1 tbody').on( 'click', 'button', function () {
      var data = t.row( $(this).parents('tr') ).data();
    } );

    $("#viewModal").on('hide.bs.modal',function(){
      submit_button.style.display = 'none';
      submit_button.value = '';
      document.getElementById('user_form').reset();
    });

  </script>

</body>
</html>