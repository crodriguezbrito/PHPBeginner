<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require, de momento en admin no hace falta ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
	</div>
	<div id="page">
		<h2>Admin Menu</h2>
		<p>Welcome to the admin area.</p>
		<ul>
				<li><a href="manage_content.php">Manage Website Content</a></li>
				<li><a href="manage_admins.php">Manage Admin Users</a></li>
				<li><a href="logout.php">Logout</a></li>
		</ul>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
		