<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>


<?php
	$current_page = find_page_by_id($_GET["page"]);
	if(!$current_page){
		// subject ID was missing or invalid or subject couldn´t be found in database
		redirect_to("manage_content.php");
	}


	//DATA
	$id = $current_page["id"];
	//QUERY
	$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";

	$result = mysqli_query($connection,$query);
	if($result && mysqli_affected_rows($connection) == 1){
		//success
		$_SESSION["message"] = "Page deleted.";
		redirect_to("manage_content.php");

	}else{
		//fail
		$_SESSION["message"] = "Page deletion failed.";
		redirect_to("manage_content.php?page={$id}");
	}
 ?>