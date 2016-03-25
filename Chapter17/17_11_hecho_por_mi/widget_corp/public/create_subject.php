<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php");?>
<?php require_once("../includes/validation_functions.php");?>


<?php
	if(isset($_POST["submit"])){
		//Process the form
		$menu_name = mysql_prep($_POST["menu_name"]); //mirar functions.php
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];

		//validations
		$required_fields = array("menu_name", "position", "visible");
		validate_presences($required_fields);

		$fields_with_max_lenghts = array("menu_name" => 30);
		validate_max_lengths($fields_with_max_lenghts);

		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");
		}

		//Query insert
		$query = "INSERT INTO subjects (";
		$query .= " menu_name, position, visible";
		$query .= ") VALUES (";
		$query .= "  '{$menu_name}', {$position}, {$visible}";
		$query .= ")";

		$result = mysqli_query($connection,$query);

		if($result){
			//success
			$_SESSION["message"] = "Subject created.";
			redirect_to("manage_content.php");
		}else{
			//faillure
			$_SESSION["message"] = "Subject creation failed.";
			redirect_to("new_subject.php");
		}
	}else{
		//This is probably a get request
		redirect_to("new_subject.php");
	}
?>

<?php
  if (isset($connection)){
  	mysqli_close($connection);
  }
?>