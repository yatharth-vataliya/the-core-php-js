<?php 

require_once("db.php");

$st = $pdo->query('SELECT * FROM countries');

$countries = $st->fetchAll(PDO::FETCH_OBJ);

$st = $pdo->query('SELECT * FROM geoinfo ORDER BY id DESC');

$geoinfo = $st->fetchAll(PDO::FETCH_OBJ);
$no = 1;
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

	<title>Prac 13</title>
	<link rel="stylesheet" type="text/css" href="asset/css/all.css">
	<script src="asset/js/all.js" type="text/javascript"></script>
</head>
<body>

	<div class="container-fluid">
		<div class="row p-2">
			<div class="col-md-5">
				<select name="country" id="country" class="custom-select" onchange="getState(this.value);">
					<option selected="" disabled="" value="">-- select any country --</option>
					<?php foreach ($countries as $country): ?>
						<option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>}
						option
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<div class="row p-2">
			<div class="col-md-5">
				<select name="state" id="state" onchange="getCity(this.value);" class="custom-select">
					<option selected="" disabled="" value="">-- select any state --</option>
				</select>
			</div>
		</div>
		<div class="row p-2">
			<div class="col-md-5">
				<select name="city" id="city" class="custom-select">
					<option selected="" disabled="" value="">-- select any city --</option>
				</select>
			</div>
		</div>
		<div class="row p-2">
			<input type="hidden" id="geoinfo" name="geoinfo" value="">
			<input type="button" id="save_data" onclick="saveData();" value="save" class="btn btn-outline-success">
		</div>
		<div class="row p-2 shadow">
			<table class="table">
				<thead>
					<tr>
						<th>No.</th>
						<th>City</th>
						<th>State</th>
						<th>Country</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($geoinfo as $geo): ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<?php 
							$st = $pdo->prepare('SELECT * FROM cities WHERE id='.$geo->city_id.' LIMIT 1');
							$st->execute();
							$city = $st->fetchAll(PDO::FETCH_OBJ);
							$st = $pdo->prepare('SELECT * FROM states WHERE id='.$city[0]->state_id.' LIMIT 1');
							$st->execute();
							$state = $st->fetchAll(PDO::FETCH_OBJ);
							$st = $pdo->prepare('SELECT * FROM countries WHERE id='.$state[0]->country_id.' LIMIT 1');
							$st->execute();
							$country = $st->fetchAll(PDO::FETCH_OBJ);
							?>
							<td><?php echo $city[0]->name; ?></td>
							<td><?php echo $state[0]->name; ?></td>
							<td><?php echo $country[0]->name; ?></td>
							<td><button type="button" onclick="editGeoInfo(<?php echo $geo->id ?>);" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>


	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

	<script>
		function getState(country_id = null,state_id = null){
			var http = new XMLHttpRequest();
			http.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					response = JSON.parse(this.response);
					data = response.data;
					states = `<option selected="" disabled="" value="">-- select any state --</option>`;
					for(i = 0; i < data.length; i++){
						states += `<option value="${parseInt(data[i].id)}">${data[i].name}</option>`;
					}
					document.getElementById('state').innerHTML = states;
					if(state_id != null){
						document.getElementById('state').value = state_id;
					}
				}
			}
			http.open("GET",`geoapi.php?country_id=${country_id}`);
			http.send();
		}

		function getCity(state_id = null,city_id = null){
			var http = new XMLHttpRequest();
			http.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					response = JSON.parse(this.response);
					data = response.data;
					cities = `<option selected="" disabled="" value="">-- select any city --</option>`;
					for(i = 0; i < data.length; i++){
						cities += `<option value="${parseInt(data[i].id)}">${data[i].name}</option>`;
					}
					document.getElementById('city').innerHTML = cities;
					if(city_id != null){
						document.getElementById('city').value = city_id;
					}
				}
			}
			http.open("GET",`geoapi.php?state_id=${state_id}`);
			http.send();
		}

		function saveData(){
			in_up = document.getElementById('save_data').value;
			city_id = document.getElementById("city").value;
			var geoinfo;
			if(in_up == 'save'){
				var http = new XMLHttpRequest();
				http.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						response = JSON.parse(this.response);
						window.location.reload();
					}
				}
				http.open("POST","geoapi.php");
				formData = new FormData();
				formData.append("city_id",city_id);
				formData.append("type",'save');
				http.send(formData);

			}else if(in_up == 'update'){
				geoinfo = document.getElementById("geoinfo").value;
				var http = new XMLHttpRequest();
				http.onreadystatechange = function(){
					if(this.readyState == 4 && this.status == 200){
						response = JSON.parse(this.response);
						document.getElementById('save_data').value = 'save';
						window.location.reload();
					}
				}
				http.open("POST","geoapi.php");
				formData = new FormData();
				formData.append("city_id",city_id);
				formData.append('geoinfo',geoinfo);
				formData.append("type",'update');
				http.send(formData);				

			}else{

			}
			
		}
		function editGeoInfo(geo_id){
			document.getElementById('save_data').value = 'update';
			document.getElementById('geoinfo').value = geo_id;
			var http = new XMLHttpRequest();
			http.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					response = JSON.parse(this.response);
					countries = document.getElementById('country');
					all_state = response.all_state;
					countries.value = response.country[0].id;

					/*for(i = 0; i < countries.length; i++){
						if(parseInt(countries[i].value) == parseInt(response.country[0].id)){
							countries[i].selected = true;
						}
					}*/

					// getState(parseInt(response.country[0].id));

					// var dynamic_state;
					// for(i = 0; i < all_state.length; i++){
					// 	is_selected = (all_state[i].name == response.state[0].name) ? 'selected' : '';
					// 	dynamic_state += `<option value="${parseInt(all_state[i].id)}" ${is_selected}>${all_state[i].name}</option>`;
					// }

					// document.getElementById('state').innerHTML = dynamic_state;
					getState(response.country[0].id,response.state[0].id);
					getCity(response.state[0].id, response.city[0].id);
					// document.getElementById('city').value = response.city[0].id;
					// console.log(response.city[0].id);

					// states = document.getElementById('state');
					// states.value = response.state[0].id;
					/*for(i = 0; i < states.length; i++){
						if(parseInt(states[i].value) == parseInt(response.state[0].id)){
							states[i].selected = true;
							console.log('enter in loop');
							break;
						}
					}*/
				}
			}


			http.open('POST','geoapi.php',true);
			formData = new FormData();
			formData.append("geo_id",geo_id);
			formData.append("type","edit");
			http.send(formData);

		}
	</script>


</body>
</html>