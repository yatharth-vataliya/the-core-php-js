<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 3</title>
</head>
<body>
	<div>

		<!-- we can use input type="number" instead of text box for avoiding some javascript -->
		Price <input type="text" name="price" id="price" value="0" oninput="calculate()"> X Qty. <input type="text" name="quantity" id="quantity" value="0" oninput="calculate()">
	</div>

	<p id="total"></p>
	<script>
		var total = 0;
		var p_value = document.querySelector("#total");
		p_value.innerHTML = total;
		function calculate(){
			let price = parseFloat(document.querySelector("#price").value);
			let quantity = parseFloat(document.querySelector("#quantity").value);
			total = price * quantity;
			isNaN(total) ? p_value.innerHTML = 0 : p_value.innerHTML = total;
		}
	</script>
</body>
</html>