<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>

<?php
	// 2. Perform database query
	$query  = "SELECT * ";
	$query .= "FROM subjects ";
	$query .= "WHERE visible = 1 ";
	$query .= "ORDER BY position ASC";
	$result = mysqli_query($connection, $query);
	confirm_query($result); //mirar funcion en includes/functions.php

?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		<ul class="subjects">
		<?php
			// 3. Use returned data (if any)
			while($subject = mysqli_fetch_assoc($result)) {
				// output data from each row
		?>
			<li><?php echo $subject["menu_name"] . " (" . $subject["id"] . ")"; ?></li>
	  <?php
			}
		?>
		</ul>
	</div>
	<div id="page">
		<h2>Manage Content</h2>	
	</div>
</div>
<?php
	// 4. Release returned data
	 mysqli_free_result($result);
?>
<?php
  // 5. Close database connection
  mysqli_close($connection);
?>
<?php include("../includes/layouts/footer.php"); ?>
<?php
  // 5. Close database connection
  mysqli_close($connection);
?>