<?php
session_start();
require_once "helper.php";

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

    <title>Prac 21</title>
</head>
<body>


<div class="container-fluid">
    <div class="fade_out_alert alert m-2 shadow p-2" style="display: none;">

    </div>
    <?php if (!empty(session('info'))): ?>
        <div class="fade_out_alert alert alert-success m-2 shadow p-2">
            <?php echo old('info'); ?>
        </div>
    <?php endif; ?>
    <?php if (!empty(session('error'))): ?>
        <div class="fade_out_alert alert alert-danger p-2">
            <?php echo old('error'); ?>
        </div>
    <?php endif; ?>
    <div class="row p-2">
        <div class="col-md-6">
            <form action="upload_file.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="user_files[]" class="custom-file" multiple>
                <input type="submit" value="Upload File" class="btn btn-outline-info">
            </form>
        </div>
        <div class="col-md-6">
            <form id="images_upload_form" method="POST" enctype="multipart/form-data">
                <input type="file" name="user_files[]" class="custom-file" multiple>
                <button type="button" id="images_submit" class="btn btn-outline-success">Upload File Using Ajax</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var timeout = setTimeout(function () {
        $(".fade_out_alert").fadeOut();
    }, 2000);

    $("#images_submit").click(function(){
        var form_data = new FormData(document.getElementById('images_upload_form'));
        $.ajax({
            url: 'upload_file.php',
            type: 'POST',
            data: form_data,
            processData: false,
            contentType: false
        }).done(res =>{
            response = JSON.parse(res);
            if(response.check){
                $("#images_upload_form").trigger('reset');
                $(".fade_out_alert").addClass('alert-success').css('display','block').html(response.info);
            }else{
                $(".fade_out_alert").addClass('alert-danger').css('display','block').html(response.error);
            }
            clearTimeout(timeout);
            setTimeout(function(){
                $(".fade_out_alert").fadeOut();
            },2500);
        });
    });

</script>

</body>
</html>