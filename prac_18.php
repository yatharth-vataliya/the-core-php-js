<?php
require_once("db.php");

$st = $pdo->query('SELECT * FROM states LIMIT 20');
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>

    </style>
    <title>Prac 18</title>
</head>

<body>
<div class="container-fluid">
    <div class="row p-2">
        <div class="col-md-6">
            <select name="state" id="state" class="custom-select"
                    onchange="getDefaultParties();getParticularParties(this.value)">
                <?php foreach ($states as $state): ?>
                    <option value="<?php echo $state->id; ?>"><?php echo $state->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="row rounded">
        <div class="col-md-3 m-2 text-white">
            <ul class="p-2 bg-success rounded connectedSortable" id="sortable1">
            </ul>
        </div>
        <div class="col-md-3 m-2 text-white">
            <ul class="p-2 rounded connectedSortable bg-warning" id="sortable2">

            </ul>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>

    function getDefaultParties() {
        var data = new FormData();
        data.append("want", "parties");

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4 && this.status == 200) {
                response = JSON.parse(this.response);
                sortable1 = document.getElementById('sortable1');
                parties = response.parties;
                var d_party = '';
                for (i = 0; i < parties.length; i++) {
                    d_party += `
                        <li class="p-1 text-decoration-none" data-id="${parties[i].id}">${parties[i].party_name}</li>
                    `;
                }
                sortable1.innerHTML = d_party;
            }
        });

        xhr.open("POST", "http://localhost/yatharth/api_task_18.php");

        xhr.send(data);
    }

    function getParticularParties(state_id = null) {
        var data = new FormData();
        data.append("want", "particular_parties");
        data.append("state_id", state_id);

        var xhr = new XMLHttpRequest();
        xhr.withCredentials = true;

        xhr.addEventListener("readystatechange", function () {
            if (this.readyState === 4 && this.status == 200) {
                response = JSON.parse(this.response);
                sortable2 = document.getElementById('sortable2');
                parties = response.parties;
                var party = '';
                for (i = 0; i < parties.length; i++) {
                    party += `
                        <li class="p-1" data-id="${parties[i].id}">${parties[i].party_name}</li>
                    `;
                }
                sortable2.innerHTML = party;
            }
        });

        xhr.open("POST", "http://localhost/yatharth/api_task_18.php");

        xhr.send(data);
    }

    document.addEventListener('DOMContentLoaded', function () {
        getDefaultParties();
        getParticularParties(document.getElementById('state').value);
    });

    $(function () {
        $("#sortable1").sortable({
            connectWith: ".connectedSortable",
            update: function (event, ui) {
                var state_id = document.getElementById('state').value;
                party_array = new Array();
                $("#sortable1 li").each(function () {
                    party_array.push($(this).data('id'));
                });
                form_data = new FormData();
                for (i = 0; i < party_array.length; i++) {
                    form_data.append("party_ids[]", party_array[i]);
                }
                form_data.append('want', 'reset_party');
                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        parties = response.parties;
                    }
                }
                http.open("POST", "api_task_18.php");
                http.send(form_data);
            }
        });
    });

    $(function () {
        $("#sortable2").sortable({
            connectWith: ".connectedSortable",
            update: function (event, ui) {
                var state_id = document.getElementById('state').value;
                party_array = new Array();
                $("#sortable2 li").each(function () {
                    party_array.push($(this).data('id'));
                });
                form_data = new FormData();
                for (i = 0; i < party_array.length; i++) {
                    form_data.append("party_ids[]", party_array[i]);
                }
                form_data.append('state_id', state_id);
                form_data.append('want', 'set_party');
                var http = new XMLHttpRequest();
                http.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        response = JSON.parse(this.response);
                        parties = response.parties;
                    }
                }
                http.open("POST", "api_task_18.php");
                http.send(form_data);
            }
        });
    });

</script>

</body>

</html>