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
    <div class="row p-2">
        <div class="col-md-6">
            <form action="upload_file.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="user_file" class="custom-file">
                <input type="submit" value="Upload File" class="btn btn-outline-info">
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>