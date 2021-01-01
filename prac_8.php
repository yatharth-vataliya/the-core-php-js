<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 8</title>
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
	<div style="background-color: black;width: 500px;padding: 2em;" align="center">
		<button type="button" class="btn" onclick="decrement()">-</button>
		<span id="dynamic" style="color: white; padding: 2em;font-size: 2em;">0</span>
		<button type="button" class="btn" onclick="increment()">+</button>
	</div>

	<script>
		var dynamic = 0
		function decrement(){
			--dynamic;
			document.getElementById("dynamic").innerHTML = dynamic;
		}
		function increment(){
			++dynamic;
			document.getElementById("dynamic").innerHTML = dynamic;
		}
	</script>
</body>
</html>