<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>
<?php require_once("../includes/validation_functions.php");?>


<?php find_selected_page(); //mirar en functions.php  ?>

<?php
	if(!$current_page){
		// subject ID was missing or invalid or subject couldn´t be found in database
		redirect_to("manage_content.php");
	}
 ?>


<?php
	if(isset($_POST["submit"])){
		//Process the form

		//validations
		$required_fields = array("menu_name", "subject_id", "position", "visible", "content");
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);

		if(empty($errors)){
			//Perform Update
			$id = $current_page["id"];
			$subject_id = (int) $_POST["subject_id"];
			$menu_name = mysql_prep($_POST["menu_name"]); //mirar functions.php
			$position = (int) $_POST["position"];
			$visible = (int) $_POST["visible"];
			$content = mysql_prep($_POST["content"]);

			//Query insert
			$query = "UPDATE pages SET ";
			$query .= "menu_name = '{$menu_name}', ";
			$query .= "subject_id = '{$subject_id}', ";
			$query .= "position = {$position}, ";
			$query .= "visible = {$visible}, ";
			$query .= "content = '{$content}' ";
			$query .= "WHERE id = {$id} ";
			$query .= "LIMIT 1";
			$result = mysqli_query($connection,$query);

			if($result && mysqli_affected_rows($connection) >= 0){
				//success
				$_SESSION["message"] = "Subject updated.";
				redirect_to("manage_content.php");
			}else{
				//faillure
				echo $query;
				$message= "Subject update failed.";
			}
		}
	}else{
	
	}
?>

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

		<h2>Edit subject  <?php echo htmlentities($current_page["menu_name"]); ?></h2>
		<form action="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?> " method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="<?php echo htmlentities($current_page["menu_name"]);?>" />
			</p>
			<p>Subject:
				<select name="subject_id">
					<?php
						$subject_set = find_all_subject();
						$subject_cont = mysqli_num_rows($subject_set); //numero de items de la consulta

						for($count=1;$count <= ($subject_cont); $count++){ //como no añadimos uno nuevo, la posicion solo puede estar hasta $subject_cont
							echo "<option value= \"{$count}\"";
							if($current_page["subject_id"] == $count){
								echo " selected";
							}
							echo ">{$count}</option>";	
						}
					?>
				</select>
			</p>
			<p>Position:
				<select name="position">
					<?php
						$page_set = find_pages_for_subject($current_page["subject_id"]);
						$page_cont = mysqli_num_rows($page_set); //numero de items de la consulta
						for($count=1;$count <= ($page_cont); $count++){ //como no añadimos uno nuevo, la posicion solo puede estar hasta $subject_cont
							echo "<option value= \"{$count}\"";
							if($current_page["position"] == $count){
								echo " selected";
							}
							echo ">{$count}</option>";	
						}
					?>
				</select>
			</p>
			<p>Visible:
				<input type="radio" name="visible" value="0" <?php if ($current_page["visible"] == 0) {echo "checked";} ?> /> No
				&nbsp;
				<input type="radio" name="visible" value="1" <?php if ($current_page["visible"] == 1) {echo "checked";} ?> /> Yes
			</p>
			<p>Content:</p> <br/>
			<textarea name="content" rows="10" cols="50" > <?php echo htmlentities($current_page["content"]);?>  </textarea> <br/><br/>

			<input type="submit" name="submit" value="Edit subject" />
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_page.php?page=<?php echo urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure to delete?'); ">Delete page</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
