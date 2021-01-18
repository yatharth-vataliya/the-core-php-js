<!DOCTYPE html>
<html>
<head>
	<title>Prac 1</title>
</head>
<body>
	
	<div>
		<input type="text" id="dynamic_text" name="dynamic_text" oninput="render(this.value)">
	</div>

	<p id="rendor">
		
	</p>

<script>
	function render(value){
		document.getElementById("rendor").innerHTML = value;
	}
</script>

</body>
</html>