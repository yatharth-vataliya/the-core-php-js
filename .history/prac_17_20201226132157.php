<?php

require_once("db.php");

$st = $pdo->prepare('SELECT * FROM sort_it ORDER BY order_id ASC');
$st->execute();

$data = $st->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <style>

  </style>
  <title>Title</title>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-5">
        <ul id="sortable" class="p-2">
         <?php foreach($data as $dt): ?>
          <li class="p-2 alert alert-info" data-id="<?php echo $dt->id; ?>"><?php echo $dt->product_name; ?></li>
         <?php endforeach; ?>
        </ul>
      </div>
    </div>    
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
    $( function() {
      $( "#sortable" ).sortable({
        update: function(event,ui){
          var od_array = new Array();
          $("#sortable li").each(function(){
            od_array.push($(this).data("id"));
          });
          var http = new XMLHttpRequest();
          http.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){

            }
          }
          http.open("POST","reorder.php");
          form_data = new FormData();
          for(i = 0; i < od_array.lenght; i++){
            form_data.append('data_id[]',od_array[i]);
          }
          http.send(form_data);
        }
      });
      $( "#sortable" ).disableSelection();
    });


  </script>

</body>
</html>