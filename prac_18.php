<?php

require_once("db.php");

$st = $pdo->prepare('SELECT * FROM sort_it ORDER BY order_id ASC');
$st->execute();

$data = $st->fetchAll(PDO::FETCH_OBJ);

$st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb1_order IS NOT NULL ORDER BY tb1_order ASC');
$st->execute();

$tb1 = $st->fetchAll(PDO::FETCH_OBJ);

$st = $pdo->prepare('SELECT * FROM tabular_sorting WHERE tb2_order IS NOT NULL ORDER BY tb2_order ASC');
$st->execute();

$tb2 = $st->fetchAll(PDO::FETCH_OBJ);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

    </style>
    <title>Prac 18</title>
</head>

<body>
<div class="container-fluid">

</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function () {
        $("#sortable").sortable({
            update: function (event, ui) {
                var od_array = new Array();
                $("#sortable li").each(function () {
                    od_array.push($(this).data("id"));
                });
                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        alert(response.message);
                    }
                }
                http.open("POST", "reorder.php");
                form_data = new FormData();
                for (i = 0; i < od_array.length; i++) {
                    form_data.append('data_id[]', od_array[i]);
                }
                http.send(form_data);
            }
        });
        $("#sortable").disableSelection();
    });

    $(function () {
        $("#sortable1").sortable({
            connectWith: ".connectedSortable",
            update: function (event, ui) {

                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        console.log(response);
                    }
                }

                var od_array1 = new Array();

                $("#sortable1 li").each(function () {
                    od_array1.push($(this).data("id"));
                });

                form_data = new FormData();
                for (i = 0; i < od_array1.length; i++) {
                    form_data.append('tb1_ids[]', od_array1[i]);
                }

                http.open("POST", "sort_save.php");
                http.send(form_data);

            }
        }).disableSelection();
    });

    $(function () {
        $("#sortable2").sortable({
            connectWith: ".connectedSortable",
            update: function (event, ui) {

                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        console.log(response);
                    }
                }

                var od_array2 = new Array();

                form_data = new FormData();

                $("#sortable2 li").each(function () {
                    od_array2.push($(this).data("id"));
                });

                for (i = 0; i < od_array2.length; i++) {
                    form_data.append('tb2_ids[]', od_array2[i]);
                }
                http.open("POST", "sort_save.php");
                http.send(form_data);

            }
        }).disableSelection();
    });

</script>

</body>

</html>