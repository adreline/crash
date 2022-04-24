<?php
require_once Crash::$element['user'];
/*
* This controller processes register and login
*/
	function process($req, $template='default'){
	echo $req."<br>";
		switch($_SERVER["REQUEST_METHOD"]){
			case "POST":
			print_r($_POST);
			break;
		}
	}
?>
