<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 9</title>
	<style type="text/css" media="screen">
		.btn{
			padding: 2em;
			height: 20px;
			width: 20px;
			margin: 2em;
			border-radius: 20%;
		}
	</style>
</head>
<body>
	<button type="button" onclick="generate();">New</button>
	<div id="render">
		<div style="background-color: black;width: 300px;padding: 1em;margin: 1em;float:left;" align="center">
			<button type="button" class="btn" onclick="decrement()">-</button>
			<span id="dynamic_0" style="color: white; padding: 1em;font-size: 1em;">0</span>
			<button type="button" class="btn" onclick="increment()">+</button>
		</div>
	</div>
	<script>
		var dynamic = [0];
		var row = 1;

		function generate(){
			let html = `<div style="background-color: black;width: 300px;padding: 1em;margin: 1em;float:left;" align="center">
			<button type="button" class="btn" onclick="decrement(${row})">-</button>
			<span id="dynamic_${row}" style="color: white; padding: 1em;font-size: 1em;">0</span>
			<button type="button" class="btn" onclick="increment(${row})">+</button>
		</div>`;
		row++;
		document.getElementById('render').innerHTML += html;
		}

		function decrement(row = 0){
			console.log(row);
			isNaN(dynamic[row]) ? dynamic[row] = 0 : "";
			--dynamic[row];
			document.getElementById("dynamic_"+row).innerHTML = dynamic[row];
		}
		function increment(row = 0){
			console.log(row);
			isNaN(dynamic[row]) ? dynamic[row] = 0 : "";
			++dynamic[row];
			document.getElementById("dynamic_"+row).innerHTML = dynamic[row];
		}
	</script>
</body>
</html>