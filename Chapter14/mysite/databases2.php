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
	//2.- Perform database query
	$query = "SELECT * ";			//example of concatenation query
	$query .= "FROM subjects ";
	$query .= "WHERE visible = 1 ";
	$result = mysqli_query($connection,$query);
	//Test if there was a query error  (Note only error in the query, not if the result of the query = 0)
	if(!$result){
		die("Database query failed");
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
	<head>
		<title>BBDD</title>
	</head>
	<body>
		<?php
		/*
			//3.-Use returned data (if any) with mysqli_fetch_row
			echo "using with mysqli_fecth_row";
			while($row = mysqli_fetch_row($result)){
				//output data from each row
				var_dump($row);
				echo "<hr/ >";
			}
		*/
		?>
		<br/><br/>
		<ul>
		<?php
			//3.-Use returned data (if any) with mysqli_fetch_assoc
			echo "Using with mysqli_fecth_assoc <br/><br/>";
			while($subject = mysqli_fetch_assoc($result)){

		?>
			<li><?php echo $subject["menu_name"] . " (" . $subject["id"] . ")"; ?></li>
		<?php		
			}
		?>
		</ul>
		<br/><br/>
		<?php
			/*
			//3.-Use returned data (if any) with mysqli_fetch_array
			echo "using with mysqli_fecth_array";
			while($row = mysqli_fetch_array($result)){
				//output data from each row
				var_dump($row);
				echo "<hr/ >";
			}
			*/
		?>
		<?php
			//4.-Release returned data
			mysqli_free_result($result);
		?>

	</body>
</html>

<?php
	//5.-Close database connection
	mysqli_close($connection);
?>