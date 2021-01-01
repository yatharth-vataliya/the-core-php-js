<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 5</title>
</head>
<body>
	<div style="padding : 2px 2px 2px 2px;margin-left: 10px;">
		<select name="unit" id="unit" onchange="change_unit(this.value);">
			<option value="" disabled selected>-- select any convert unit --</option>
			<!-- <option value="speed">speed</option> -->
			<option value="temperature">Temperature</option>
			<option value="time">Time</option>
			<!-- <option value="volume">Volume</option> -->
		</select>
	</div>
	<br/>
	<br/>
	<p id="left_p"></p> <input type="text" id="left_val" value="0" oninput="left_cal(this.value)">
	<p id="right_p"></p> <input type="text" value="0" id="right_val" oninput="right_cal(this.value)">
	<script>

		document.onload = change_unit("");
		var unit;
		var right = document.getElementById("right_val");
		var left = document.getElementById("left_val");

		function change_unit(unit){
			switch(unit){
				case 'time':
					left.value = 3600;
					left_cal(3600);
					document.getElementById("left_p").innerHTML = 'Second';
					document.getElementById("right_p").innerHTML = 'Minute';
					break;
				case 'temperature':
					left.value = 0;
					left_cal(0);
					document.getElementById("left_p").innerHTML = 'celsius';
					document.getElementById("right_p").innerHTML = 'Fahrenheit';
					break;
				default:
					left_cal(0);
					document.getElementById("left_p").innerHTML = 'celsius';
					document.getElementById("right_p").innerHTML = 'Fahrenheit';
					break;
			}
		}

		function right_cal(value){
			unit = document.getElementById("unit").value;
			switch(unit){
				case 'time':
					minute = parseFloat(value);
					seconds = minute * 60;
					isNaN(seconds) ? left.value = '' :  left.value = seconds;
					break;
				case 'temperature':
					fahr = parseFloat(value);
					cel = (fahr - 32) * 5/9;
					isNaN(cel) ? left.value = '' : left.value = cel;
					break;
				default:
					
					break;
			}	
		}

		function left_cal(value){
			unit = document.getElementById("unit").value;
			switch(unit){
				case 'time':
					seconds = parseFloat(value);
					minute = seconds / 60;
					isNaN(minute) ? right.value = '' : right.value = minute;
					break;
				case 'temperature':
					cels = parseFloat(value);
					fah = (cels * 9/5) + 32;
					isNaN(fah) ? right.value = "" : right.value = fah;
					break;
				default:
					cels = parseFloat(value);
					fah = (cels * 9/5) + 32;
					isNaN(fah) ? document.getElementById("right_val").value = "" : document.getElementById("right_val").value = fah;
					break;
			}	
		}
	</script>
</body>
</html>