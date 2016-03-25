<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>

<?php find_selected_page(); //mirar en functions.php  ?>

<?php
	if(!$current_subject){
		// subject ID was missing or invalid or subject couldn´t be found in database
		redirect_to("manage_content.php");
	}
 ?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php echo message(); //mirar en session.php?> 
		<?php $errors = errors(); //mirar en session.php  ?>
		<?php echo form_errors($errors); //mirar en functions.php ?>
		<h2>Edit subject  <?php echo $current_subject["menu_name"]; ?></h2>
		<form action="create_subject.php" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="<?php echo $current_subject["menu_name"];?>" />
			</p>
			<p>Position:
				<select name="position">
					<?php
						$subject_set = find_all_subject();
						$subject_cont = mysqli_num_rows($subject_set); //numero de items de la consulta
						for($count=1;$count <= ($subject_cont); $count++){ //como no añadimos uno nuevo, la posicion solo puede estar hasta $subject_cont
							echo "<option value= \"{$count}\"";
							if($current_subject["position"] == $count){
								echo " selected";
							}
							echo ">{$count}</option>";	
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" <?php if ($current_subject["visible"] == 0) {echo "checked";} ?> /> No
				&nbsp;
				<input type="radio" name="visible" value="1" <?php if ($current_subject["visible"] == 1) {echo "checked";} ?> /> Yes
			</p>
			<input type="submit" name="submit" value="Edit subject" /> 
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
