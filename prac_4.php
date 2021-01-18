<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 4</title>
</head>
<body>
	Celsius <input type="text" name="celsius" id="celsius" value="0" oninput="calculateFah(this.value);">
	Fahrenheit <input type="text" name="fahrenheit" id="fahrenheit" oninput="calculateCel(this.value);">
	<script>
		document.onload = calculateFah(0);
		function calculateFah(cel){
			let cels = parseFloat(cel);
			fah = (cels * 9/5) + 32;
			isNaN(fah) ? document.querySelector("#fahrenheit").value = "" : document.querySelector("#fahrenheit").value = fah.toFixed(2);
		}
		function calculateCel(fah){
			let fahr = parseFloat(fah);
			cel = (fahr - 32) * 5/9;
			isNaN(cel) ? document.querySelector("#celsius").value = "" : document.querySelector("#celsius").value = cel.toFixed(2);
		}
	</script>
</body>
</html>