<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>
<?php require_once("../includes/validation_functions.php");?>


<?php find_selected_page(); //mirar en functions.php  ?>

<?php
	if(!$current_subject){
		// subject ID was missing or invalid or subject couldn´t be found in database
		redirect_to("manage_content.php");
	}
 ?>


<?php
	if(isset($_POST["submit"])){
		//Process the form

		//validations
		$required_fields = array("menu_name", "position", "visible");
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);

		if(empty($errors)){
			//Perform Update
			$id = $current_subject["id"];
			$menu_name = mysql_prep($_POST["menu_name"]); //mirar functions.php
			$position = (int) $_POST["position"];
			$visible = (int) $_POST["visible"];

			//Query insert
			$query = "UPDATE subjects SET ";
			$query .= "menu_name = '{$menu_name}', ";
			$query .= "position = {$position}, ";
			$query .= "visible = {$visible} ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection,$query);

			if($result && mysqli_affected_rows($connection) >= 0){
				//success
				$_SESSION["message"] = "Subject updated.";
				redirect_to("manage_content.php");
			}else{
				//faillure
				$message= "Subject update failed.";
			}
		}
	}else{
	
	}
?>

<?php $layout_context = "admin"; ?> 
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php
			if(!empty($message)){ //$message just a variable, not use a session
				echo "<div class =\"message\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); //mirar en functions.php ?>

		<h2>Edit subject  <?php echo htmlentities($current_subject["menu_name"]); ?></h2>
		<form action="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?> " method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_subject["menu_name"]);?>" />
			</p>
			<p>Position:
				<select name="position">
					<?php
						$subject_set = find_all_subject(false);
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
		&nbsp;
		&nbsp;
		<a href="delete_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>" onclick="return confirm('Are you sure to delete?'); ">Delete subject</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
