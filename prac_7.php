<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 7</title>
</head>
<body>
	<ul id="list_one">
		<li>Coffee</li>
		<li>Tea</li>
	</ul>

	<ul id="list_two">
		<li>Water</li>
		<li>Milk</li>
	</ul>

	Click the button to copy an item from one list to another
	<br/>
	<br/>
	<button type="button" id="copy" onclick="appendHtml();">Tri it</button>

	<script>
		function appendHtml(){
			var element = document.getElementById('list_two').lastElementChild;
			var clo = element.cloneNode(true);
			document.getElementById('list_one').appendChild(clo);
		}
	</script>
</body>
</html>