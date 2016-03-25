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
	$menu_name = "Edit me";
	$position = 4;
	$visible = 1;

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