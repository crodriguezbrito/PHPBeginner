<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require, de momento en admin no hace falta ?>
<?php require_once("../includes/db_connection.php"); ?>

<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php"); ?>
<div id="main">
	<div id="navigation">
	</div>
	<div id="page">
		<h2>Manage Admins</h2>
		 
		<?php //MEQUEDEAQUI
			$admins_set = find_all_admins();
			$output = "<ul>";
			$output .= "<p>Username</p>";
			while($admin = mysqli_fetch_assoc($admins_set)){
				
					$output .= "<li>";
						$output .= htmlentities($admin["username"]);
					$output .= "</li>";
			}
			mysqli_free_result($admins_set);
			$output .= "</ul>";
			echo $output;
		 ?>
		<ul>
				<li><a href="manage_content.php">Manage Website Content</a></li>
				<li><a href="manage_admins.php">Manage Admin Users</a></li>
				<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>