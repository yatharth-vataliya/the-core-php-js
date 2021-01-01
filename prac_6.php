<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 6</title>
	<style type="text/css">
		.colorBox{
			padding: 1em 1em 1em 1em;
			background-color: rgb(--red,--green,--blue);
			margin-bottom:	2em;
		}
	</style>
</head>
<body>
	<div>
		<div class="colorBox" id="colorBox">
			
		</div>
		<div>
			<table>
				<tbody>
					<tr>
						<td>R: <input type="number" value="0" min="0" max="255" name="red" id="red" oninput="setColor();"></td>
						<td>
							<?php for($i = 0; $i<= 255; $i++): ?>
								<span style="padding:1px;margin:0;height:22px;background-color: rgb(<?php echo $i; ?>,0,0)" onclick="danger(<?php echo $i; ?>);" onmouseover="danger(<?php echo $i; ?>)" onmouseup="danger(<?php echo $i; ?>);" onmousedown="danger(<?php echo $i; ?>);"></span>
							<?php endfor; ?>
						</td>
					</tr>
					<tr>
						<td>G: <input type="number" value="0" min="0" max="255" name="green" id="green" oninput="setColor();"></td>
							<td>
							<?php for($i = 0; $i<= 255; $i++): ?>
								<span style="padding:1px;margin:0;height:22px;background-color: rgb(0,<?php echo $i; ?>,0)" onmouseover="success(<?php echo $i; ?>)" onmouseup="success(<?php echo $i; ?>);" onmousedown="success(<?php echo $i; ?>);"></span>
							<?php endfor; ?>
						</td>
					</tr>
					<tr>
						<td>B: <input type="number" value="0" min="0" max="255" name="blue" id="blue" oninput="setColor();"></td>
						<td>
							<?php for($i = 0; $i<= 255; $i++): ?>
								<span style="padding:1px;margin:0;height:22px;background-color: rgb(0,0,<?php echo $i; ?>)" onmouseover="primary(<?php echo $i; ?>)" onmouseup="primary(<?php echo $i; ?>);" onmousedown="primary(<?php echo $i; ?>);"></span>
							<?php endfor; ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>	

		<script>
			function danger(shad){
				document.getElementById("red").value = shad;
				setColor();
			}
			function success(shad){
				document.getElementById("green").value = shad;
				setColor();
			}
			function primary(shad){
				document.getElementById("blue").value = shad;
				setColor();
			}

			function setColor(){
				red = document.getElementById("red").value;
				green = document.getElementById("green").value;
				blue = document.getElementById("blue").value;
				document.getElementById("colorBox").style.backgroundColor = `rgb(${red},${green},${blue})`;

			}
		</script>

</body>
</html>