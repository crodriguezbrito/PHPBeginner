<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_page(); //mirar en functions.php  ?>
<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php
			if($current_subject){
		?>
				<h2>Manage Content</h2>
				Menu name: <?php  echo $current_subject["menu_name"];  ?>
		<?php		
			}elseif ($current_page) {
		?>
				<h2>Manage Page</h2>
				Menu name: <?php  echo $current_page["menu_name"];  ?>
		<?php		
			}else {
				echo "Please select a subject or a page";
			}
		 ?>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
