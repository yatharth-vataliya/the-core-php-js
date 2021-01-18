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
    <title>Prac 17</title>
</head>

<body>
<div class="container-fluid">
    <div class="row mt-4">
        <div class="col-md-5">
            <ul id="sortable" class="p-2 all_sortable">
                <?php foreach ($data as $dt) : ?>
                    <li class="p-2 alert alert-info"
                        data-id="<?php echo $dt->id; ?>"
                        data-name="<?php echo $dt->product_name; ?>"><?php echo $dt->product_name; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md">
            <div class="row">
                <div class="col-md-5">
                    <ul id="sortable1" class="p-2 all_sortable connectedSortable bg-secondary">
                        <?php foreach ($tb1 as $dt) : ?>
                            <li class="p-2 alert alert-info"
                                data-id="<?php echo $dt->id; ?>"><?php echo $dt->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-5">
                    <ul id="sortable2" class="p-2 all_sortable connectedSortable bg-dark">
                        <?php foreach ($tb2 as $dt) : ?>
                            <li class="p-2 alert alert-warning"
                                data-id="<?php echo $dt->id; ?>"><?php echo $dt->name; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    $(function () {
        $("#sortable").sortable({
            connectWith: ".connectedSortable",
            update: function (event, ui) {
                var od_array = new Array();
                $("#sortable li").each(function () {
                    od_array.push($(this).data("id"));
                });
                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        console.log(response.message);
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
                        tb1 = response.tb1;
                        srt1 = '';
                        if (tb1 != null) {
                            for (i = 0; i < tb1.length; i++) {
                                srt1 += `
                                 <li class="p-2 alert alert-info" data-id="${tb1[i].id}">${tb1[i].name}</li>
                            `;
                            }
                        }

                        tb2 = response.tb2;
                        srt2 = ' ';
                        if (tb2 != null) {
                            for (i = 0; i < tb2.length; i++) {
                                srt2 += `
                                 <li class="p-2 alert alert-warning" data-id="${tb2[i].id}">${tb2[i].name}</li>
                            `;
                            }
                        }
                        document.getElementById('sortable2').innerHTML = srt2;

                        document.getElementById('sortable1').innerHTML = srt1;
                    }
                }

                var od_array1 = new Array();
                var od_name1 = new Array();
                $("#sortable1 li").each(function () {
                    od_array1.push($(this).data("id"));
                    od_name1.push($(this).data("name"));
                });
                // console.log(od_name1,od_array1);
                form_data = new FormData();
                for (i = 0; i < od_array1.length; i++) {
                    form_data.append('tb1_ids[]', od_array1[i]);
                }

                for (i = 0; i < od_name1.length; i++) {
                    name = null;
                    if (od_name1[i] != undefined) {
                        name = od_name1[i];
                    }
                    form_data.append('tb1_names[]', name);
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

                        tb1 = response.tb1;
                        srt1 = '';
                        if (tb1 != null) {
                            for (i = 0; i < tb1.length; i++) {
                                srt1 += `
                                 <li class="p-2 alert alert-info" data-id="${tb1[i].id}">${tb1[i].name}</li>
                            `;
                            }
                        }

                        tb2 = response.tb2;
                        srt2 = ' ';
                        if (tb2 != null) {
                            for (i = 0; i < tb2.length; i++) {
                                srt2 += `
                                 <li class="p-2 alert alert-warning" data-id="${tb2[i].id}">${tb2[i].name}</li>
                            `;
                            }
                        }

                        document.getElementById('sortable1').innerHTML = srt1;
                        document.getElementById('sortable2').innerHTML = srt2;

                    }
                }

                var od_array2 = new Array();
                var od_name2 = new Array();
                form_data = new FormData();

                $("#sortable2 li").each(function () {
                    od_array2.push($(this).data("id"));
                    od_name2.push($(this).data("name"));
                });
                // console.log(od_name2,od_array2);
                for (i = 0; i < od_array2.length; i++) {
                    form_data.append('tb2_ids[]', od_array2[i]);
                }

                for (i = 0; i < od_name2.length; i++) {
                    name = null;
                    if (od_name2[i] != undefined) {
                        name = od_name2[i];
                    }
                    form_data.append('tb2_names[]', name);
                }

                http.open("POST", "sort_save.php");
                http.send(form_data);

            }
        }).disableSelection();
    });

    var clone, before, parent
    $('.all_sortable').each(function () {
        $(this).sortable({
            connectWith: '.connectedSortable',
            helper: "clone",
            start: function (event, ui) {
                $(ui.item).show();
                clone = $(ui.item).clone();
                before = $(ui.item).prev();
                parent = $(ui.item).parent();

            },
            receive: function (event, ui) {//only when dropped from one to another!
                if (before.length) before.after(clone);
                else parent.prepend(clone);

            }
        }).disableSelection();
    });


</script>

</body>

</html>