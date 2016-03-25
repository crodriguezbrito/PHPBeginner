<?php
	//funcion que devuelve error en la consulta si no hay ninguna query que coincida con nuestra consulta en la bbdd
	function confirm_query($result_set){
		if(!$result_set){
			die("Database query failed.");
		}
	}
	//Funcion consulta bbdd devuelve todos los subject que hay, con visible = 1
	function find_all_subject(){
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set); //mirar funcion en includes/functions.php
		return $subject_set;
	}
	//Funcion consulta bbdd devuelve todas las page que hay, con visible = 1
	function find_pages_for_subject($subject_id){
		global $connection;

		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND subject_id = {$subject_id} ";  
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set); //mirar funcion en includes/functions.php
		return $page_set;
	}
	# funcion barra de navegacion, la quitamos del html y la ponemos aqui, todo lo que sea codigo html tiene que ir entre comillas y lo que va entre etiquetas php quitarselas ya que estamos en código php directamente
	# Navigation takes 2 arguments
	# - The currently selected subject ID (if any)
	# - the currently selected page ID (if any)
	function navigation($selected_subject_id,$selected_page_id){
		$output = "<ul class=\"subjects\">";
		$subject_set = find_all_subject();
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if($subject["id"] == $selected_subject_id){
				$output .= " class=\"selected\"";
			}
			$output .= ">";
				$output .= "<a href=\"manage_content.php?subject=";
				$output .= urldecode($subject["id"]);
				$output .= "\">";
				$output .= $subject["menu_name"];
				$output .= "</a>";
				$page_set = find_pages_for_subject($subject["id"]);
				$output .=	"<ul class=\"pages\">";
				while($page = mysqli_fetch_assoc($page_set)) {
					$output .= "<li";
					if($page["id"] == $selected_page_id){
						$output .= " class=\"selected\"";
					}
					$output .= ">";
						$output .= "<a href=\"manage_content.php?page=";
						$output .= urldecode($page["id"]);
						$output .= "\">";
						$output .= $page["menu_name"];
						$output .= "</a>";
					$output .= "</li>";
				}
				mysqli_free_result($page_set);	
				$output .= "</ul>";
			$output .= "</li>";
		}
		mysqli_free_result($subject_set);	
		$output .= "</ul>";
		return $output;
	}
?>