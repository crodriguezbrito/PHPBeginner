<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>

<?php $layout_context = "admin"; ?> 
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); //mirar en functions.php  ?>
<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php echo message(); //mirar en session.php?> 
		<?php $errors = errors(); //mirar en session.php  ?>
		<?php echo form_errors($errors); //mirar en functions.php ?>
		<h2>Create subject</h2>
		<form action="create_subject.php" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
				<select name="position">
					<?php
						$subject_set = find_all_subject();
						$subject_cont = mysqli_num_rows($subject_set); //numero de items de la consulta
						for($count=1;$count <= ($subject_cont +1); $count++){
							echo "<option value= \"{$count}\">{$count}</option>";	
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" /> No
				&nbsp;
				<input type="radio" name="visible" value="1" /> Yes
			</p>
			<input type="submit" name="submit" value="Create subject" /> 
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
