<?php

function has_prencese($value){
	return isset($value) && $value !== "";
}
//function print errors data = array return a list of errors during the process of validations
function form_errors($errors=array()) {
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>{$error}</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}
//funcion para comprobar que no supera el tamaño se pasa como datos un array  donde viene el nombre del campo y su valor maximo array tipo hash username => 30

?>