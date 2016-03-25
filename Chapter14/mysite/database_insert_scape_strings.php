<?php
	//1.-Create a database connection
	$dbhost = "localhost";
	$dbuser = "widget_cms";
	$dbpassword = "secretpassword";
	$dbcname = "widget_corp";
	$connection = mysqli_connect($dbhost,$dbuser,$dbpassword,$dbcname);

	// Test if connection succeeded
	if(mysqli_connect_errno()) {			//Error    						//Error Code
    	die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
    	);
  	}
?>
<?php
	//Often these are from values in the $_POST
	$menu_name = "Today's Widget Trivia";
	$position = (int) 4;  //Para asegurarnos que pasamos un int a la bbdd
	$visible = (int) 1;	//para asegurarnos que pasamos un int a la bbdd

	//Si estos valores vienen de $_Post lo normal es antes de insertarlos en la bbdd escapar las comillas con la funcion de MYSQLI
	//Escape all strings
	$menu_name = mysqli_real_escape_string($connection,$menu_name);


	//2.- Perform database query
	$query = "INSERT INTO subjects (menu_name,position,visible)";
	$query .= "VALUES ('{$menu_name}','{$position}','{$visible}')";
	
	$result = mysqli_query($connection,$query);
	//Test if there was a query error  (Note only error in the query, not if the result of the query = 0)
	if($result){
		//Success
		//redirect_to("somepage.php");
		echo "Success";
	}else{
		//Faillure
		// $message = "Subject connection failed";
		die("Database query failed " . mysql_error($connection));
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>BBDD</title>
	</head>
	<body>
		
	</body>
</html>

<?php
	//5.-Close database connection
	mysqli_close($connection);
?>