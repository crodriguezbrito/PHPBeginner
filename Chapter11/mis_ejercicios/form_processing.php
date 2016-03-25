<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>Form Proccesing</title>
	</head>
	<body>
		<pre>
			<?php
				$username = $_POST['username'];
				$password = $_POST['password'];
				echo "Hola soy {$username} y mi contraseña es {$password} <br/><br/>";
				print_r($_POST);
			?>
		</pre>

	</body>
</html>