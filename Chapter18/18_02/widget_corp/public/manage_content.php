<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); //Acuerdate de que las funciones solo hace falta que se carguen una vez, por eso se pone el require ?>

<?php $layout_context = "admin"; ?> 
<?php include("../includes/layouts/header.php"); ?>

<?php find_selected_page(); //mirar en functions.php  ?>
<div id="main">
	<div id="navigation">
		<br/>
		<a href="admin.php">&laquo; Main menu </a><br/>

		<?php echo navigation($current_subject,$current_page); ?>
		<br/>
		<a href="new_subject.php">+ Add a subject</a>
	</div>
	<div id="page">
		<?php echo message(); ?>
		<?php
			if($current_subject){
		?>
				<h2>Manage Content</h2>
				Menu name: <?php  echo htmlentities($current_subject["menu_name"]);  ?> <br/>
				Position: <?php echo $current_subject["position"];  ?> <br/>
				Visible: <?php echo $current_subject["visible"] == 1 ? 'Yes':'No';  ?> <br/><br/>

				<a href="edit_subject.php?subject=<?php echo urlencode($current_subject["id"]); ?>">Edit Subject</a>
				<hr>
				<?php //ME QUEDE AQUI ?>
				<h2>Pages in this subject:</h2>
				<?php
					$page_set = find_pages_for_subject($current_subject["id"]);
					$output =	"<ul class=\"pages\">";
						while($page = mysqli_fetch_assoc($page_set)) {
							$output .= "<li";
								$output .= ">";
								$output .= "<a href=\"manage_content.php?page=";
								$output .= urldecode($page["id"]);
								$output .= "\">";
								$output .= htmlentities($page["menu_name"]);
								$output .= "</a>";
							$output .= "</li>";
						}
					mysqli_free_result($page_set);	
					$output .= "</ul>";
					echo $output;
				?>
				<a href="new_page.php?subject=<?php echo urlencode($current_subject["id"]); ?>">+ Add page for this subject</a>

		<?php		
			}elseif ($current_page) {
		?>
				<h2>Manage Page</h2>
				Menu name: <?php  echo htmlentities($current_page["menu_name"]);  ?> <br/>
				Position: <?php echo $current_page["position"];  ?> <br/>
				Visible: <?php echo $current_page["visible"] == 1 ? 'Yes':'No';  ?> <br/><br/>
				Content: <br/>
				<div class="view-content">
					 <?php echo htmlentities($current_page["content"]);?> 
				</div>

				<a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?>">Edit Page</a>
		<?php		
			}else {
				echo "Please select a subject or a page";
			}
		 ?>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
