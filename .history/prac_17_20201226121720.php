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
          <li class="m-1 bg-success rounded">Item 1</li>
          <li class="m-1 bg-success rounded">Item 2</li>
          <li class="m-1 bg-success rounded">Item 3</li>
          <li class="m-1 bg-success rounded">Item 4</li>
          <li class="m-1 bg-success rounded">Item 5</li>
          <li class="m-1 bg-success rounded">Item 6</li>
          <li class="m-1 bg-success rounded">Item 7</li>
        </ul>
      </div>
    </div>    
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <script>
    $( function() {
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();
    });
  </script>

</body>
</html>