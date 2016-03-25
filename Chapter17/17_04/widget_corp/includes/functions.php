<?php
	//función para redireccionar paginas web
	function redirect_to($new_location){
		header("location: " . $new_location);
		exit;
	}
	//Funcion para escapar los string para posible prevencion de injeccion sql
	function mysql_prep($string){
		global $connection;
		$escaped_string = mysqli_real_escape_string($connection,$string);
		return $escaped_string;
	}
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
		//$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set); //mirar funcion en includes/functions.php
		return $subject_set;
	}
	//Funcion consulta bbdd devuelve todas las page que hay, con visible = 1
	function find_pages_for_subject($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection,$subject_id);

		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND subject_id = {$safe_subject_id} ";  
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set); //mirar funcion en includes/functions.php
		return $page_set;
	}
	//Contenido de un subject en concreto pasandole su id
	function find_subject_by_id($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection,$subject_id); //escapar el string para evitar injeccion sql

		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)){ //como sabemos que solo hay uno, devolvemos un array asociativo
			return $subject;
		}else{
			return null;
		}	
	}
	function find_page_by_id($page_id){
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection,$page_id); //escapar el string para evitar injeccion sql

		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if($page = mysqli_fetch_assoc($page_set)){ //como sabemos que solo hay uno, devolvemos un array asociativo
			return $page;
		}else{
			return null;
		}	
	}
	#Funcion que mira si lo que has seleccionado es un subject o un page desde el panel de navegacion y manda a cargar el contenido de ese tipo en concreto por su id
	function find_selected_page(){
		global $current_subject; //declaramos globales xq se van a utilizar en el html
		global $current_page;

		if(isset($_GET["subject"])){
			$current_subject = find_subject_by_id($_GET["subject"]);
			$current_page = null;
		} elseif (isset($_GET["page"])){
			$current_subject = null;
			$current_page = find_page_by_id($_GET["page"]);
		}else{
			$current_subject = null;
			$current_page = null;
		}
	}
	# funcion barra de navegacion, la quitamos del html y la ponemos aqui, todo lo que sea codigo html tiene que ir entre comillas y lo que va entre etiquetas php quitarselas ya que estamos en código php directamente
	# Navigation takes 2 arguments
	# - The current subject array or null (if any)
	# - the current  page array or null (if any)
	function navigation($subject_array,$page_array){
		$output = "<ul class=\"subjects\">";
		$subject_set = find_all_subject();
		while($subject = mysqli_fetch_assoc($subject_set)) {
			$output .= "<li";
			if($subject_array && $subject["id"] == $subject_array["id"]){
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
					if($page_array && $page["id"] == $page_array["id"]){
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