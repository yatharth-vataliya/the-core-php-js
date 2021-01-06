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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.css"/>
    <title>Prac 21</title>
</head>
<body>


<div class="container-fluid">
    <div class="fade_out_alert alert m-2 shadow p-2" style="display: none;">
    </div>
    <div class="row m-2 p-2">
        <div class="col-md-5 bg-white rounded">
            <input type="file" id="cropper_image" name="cropper_image">
            <button type="button" class="btn btn-outline-primary" id="save_image">Save Image</button>
        </div>
    </div>
    <div class="p-2">
        <img src="" id="image_placeholder" style="height: 500px; width: 500px;display: none;" alt="User Uploaded image">
    </div>

    <div class="p-2 secondary_image_preview" style="height: 50px; width: 50px; overflow: hidden;">
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.js"></script>
<script>

    const image = document.getElementById('image_placeholder');
    const cropper = new Cropper(image, {
        preview: '.secondary_image_preview'
    });
    $(document).ready(function () {
        $("#cropper_image").on('change', function () {
            let src = window.URL.createObjectURL(this.files[0]);
            $("#image_placeholder").attr('src', src).css('display', 'block');
            $("#secondary_image_preview").css('display', 'block');
            cropper.replace(src);
        });

        $("#save_image").click(function () {
            cropper.getCroppedCanvas().toBlob((blob) => {
                const form_data = new FormData();
                form_data.append('user_files', blob);
                form_data.append('is_cropper', 'yes');
                $.ajax({
                    url: 'upload_file.php',
                    type: 'POST',
                    data: form_data,
                    processData: false,
                    contentType: false
                }).done(function (response) {
                    response = JSON.parse(response);
                    if (response.check) {
                        $("#images_upload_form").trigger('reset');
                        $(".fade_out_alert").addClass('alert-success').css('display', 'block').html(response.info);
                    } else {
                        $(".fade_out_alert").addClass('alert-danger').css('display', 'block').html(response.error);
                    }
                    setTimeout(function () {
                        $(".fade_out_alert").fadeOut();
                    }, 2500);
                });
            });
        });
    });


</script>

</body>
</html>