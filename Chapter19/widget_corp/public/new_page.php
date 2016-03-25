<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>
<?php require_once("../includes/validation_functions.php");?>

<?php $layout_context = "admin"; ?> 
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); //mirar en functions.php  ?>
<?php
	if (isset($_POST["submit"])){ //Proccess the form
		$subject_id = $_GET["subject"];
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		$content = mysql_prep($_POST["content"]); 
		//validations
		$required_fields = array("menu_name", "position", "visible", "content");
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);

		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect_to("new_page.php?subject={$subject_id}");
		}

		//Query string*/

		$query = "INSERT INTO pages (";
		$query .= " menu_name, subject_id, position, visible, content";
		$query .= ") VALUES (";
		$query .= "  '{$menu_name}', {$subject_id}, {$position}, {$visible}, '{$content}'";
		$query .= ")";
		$result = mysqli_query($connection,$query);

		if($result){
			//success
			$_SESSION["message"] = "Subject created.";
			redirect_to("manage_content.php?subject={$subject_id}");
		}else{
			//faillure
			$_SESSION["message"] = "Subject creation failed.";
			redirect_to("new_page.php?subject={$subject_id}");
		}


	}


 ?>
<div id="main">
	<div id="navigation">
		<?php echo navigation($current_subject,$current_page); ?>
	</div>
	<div id="page">
		<?php echo message(); //mirar en session.php?> 
		<?php $errors = errors(); //mirar en session.php  ?>
		<?php echo form_errors($errors); //mirar en functions.php ?>
		<h2>Create subject</h2>
		<form action="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>" method="post">
			<p>Menu Name:
				<input type="text" name="menu_name" value="" />
			</p>
			<p>Position:
				<select name="position">
					<?php
						$page_set = find_pages_for_subject($current_subject["id"]);
						$page_cont = mysqli_num_rows($page_set); //numero de items de la consulta
						for($count=1;$count <= ($page_cont +1); $count++){
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
			<p>Content:</p>
			<textarea name="content" rows="10" cols="50"></textarea> <br/><br/>
			
			<input type="submit" name="submit" value="Create subject" /> 
		</form>
		<br/>
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
