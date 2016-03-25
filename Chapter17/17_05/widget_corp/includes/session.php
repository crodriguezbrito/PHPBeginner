<?php
	session_start();

	function message(){
		if(isset($_SESSION["message"])){
			$output =  "<div class=\"message\">";
			$output .= htmlentities($_SESSION["message"]);
			$output .= "</div>";

			$_SESSION["message"] = null; //una vez utilizada la session esta se destruye para que no permanezca en todas las páginas

			return $output;
		}
	}
?>