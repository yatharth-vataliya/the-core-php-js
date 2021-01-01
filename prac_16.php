<?php 

require_once("db.php");

$st = $pdo->query('SELECT * FROM states');
$states = $st->fetchAll(PDO::FETCH_OBJ);

?>

<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

  <title>Title</title>
</head>
<body>


  <div class="container-fluid">
    <div class="row p-2">
      <div class="col-md-5">
        <select class="custom-select" name="states" id="states">
          <option value=""></option>
          <?php foreach($states as $state): ?>
            <option value="<?php echo $state->name; ?>"><?php echo $state->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-md-5">
        <button type="button" onclick="setValue('California');" class="btn btn-outline-secondary">Set California</button>
        <button type="button" onclick="openSelect();" class="btn btn-outline-secondary">Open</button>
        <button type="button" onclick="closeSelect();" class="btn btn-outline-secondary">Close</button>

        <button type="button" onclick="setInit();" class="btn btn-outline-secondary">Init</button>
        <button type="button" onclick="setDestroy();" class="btn btn-outline-secondary">Destroy</button>

      </div>
    </div>
    <div class="row p-2">
      <div class="col-md-5">
        <select class="custom-select" name="states_multi" id="states_multi" multiple="">
          <?php foreach($states as $state): ?>
            <option value="<?php echo $state->name; ?>"><?php echo $state->name; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
    <div class="row p-2">
      <div class="col-md-5">
        <button type="button" onclick="setMultiValue(['California','Alabama']);" class="btn btn-outline-success">Set Alabama and California</button>
        <button type="button" onclick="setMultiValue();" class="btn btn-danger">Clear</button>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script>
    var state_sel = document.getElementById('states');
    ev = new Event('change');
    var s2 = $('#states').select2({
      placeholder: 'Select any state',
      theme: "classic",
      allowClear: true
    });

    var s2_multi = $('#states_multi').select2({
      placeholder: 'Select any state',
      allowClear: true,
      multiple: true,
      theme: "classic"
    });

    function setValue(value){
      if(value != null || value != undefined){
        state_sel.value = value;
        state_sel.dispatchEvent(ev);
      }else{
        state_sel.value = null;
        state_sel.dispatchEvent(ev);
      }
    }

    function setMultiValue(value){
       s2_multi.val(value).trigger("change");
    }

    function openSelect(){
      s2.select2('open');
    }

    function closeSelect(){
      s2.select2('close');
    }

    function setInit(){
      s2.select2({
        placeholder: 'Select any state',
        allowClear : true,
        theme: 'classic'
      });
    }
    function setDestroy(){
      s2.select2('destroy');
    }
  </script>

</body>
</html>