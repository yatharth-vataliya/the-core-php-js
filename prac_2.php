<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Prac 2</title>
</head>
<body>
	<p id="s_h_text" style="display: block;">
		You can Show and Hide me with this button
	</p>
	<button type="button" onclick="toggleText('hide')" id="hide">Hide the text above</button>
	
	<button type="button" onclick="toggleText('show')" id="show">Show the text above</button>
	<button type="button" onclick="toggleText('toggle')" id="show">Toggle Text</button>
	<script>
		function toggleText(result = null){
			t_text = document.getElementById('s_h_text');
			switch(result){
				case 'show':
					t_text.style.display = 'block';
					break;
				case 'hide':
					t_text.style.display = 'none';
					break;
				case 'toggle':
					sh = t_text.style.getPropertyValue('display');
					(sh == 'none') ? t_text.style.display = 'block' : t_text.style.display = 'none';
					break;
			}
		}
	</script>
</body>
</html>