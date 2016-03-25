<?php
//funcion que devuelve error en la consulta si no hay ninguna query que coincida con nuestra consulta en la bbdd
function confirm_query($result_set){
	if(!$result_set){
		die("Database query failed.");
	}
}
?>