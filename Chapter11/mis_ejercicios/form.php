<?php
	require_once("validation_form.php");
	$errors = array();
	$message = "";

	if(isset($_POST["sumbit"])) {

		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);

		$fields_for_evaluating = array("username","password");
		foreach ($fields_for_evaluating as $key) {
			$data = trim($_POST[$key]);
			if (!hasprecense($data)){
				errors[$data] = ucfirst($data) . " está en blanco";
			}
		}



	}else{

	}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>form</title>
	</head>
	<body>
		<form action="form_processing.php" method="post">
			Usuario:<input type="text" name="username" value="" /> <br/> 
			Paswword:<input type="password" name="password" value="" /> <br/>
			<br/>
			<input type="submit" name="submit" value="Enviar" />
		</form>

	</body>
</html>
