<?php
require_once Crash::$element['user'];
/*
* This controller processes register and login
*/
	function process($req, $template='default'){
		switch($_SERVER["REQUEST_METHOD"]){
			case "POST":
				if(isset($_POST['login'])){
					//attempt to log the user in
					//this really need sanitizing to prevent sql injection
					$username=$_POST['username'];
					$password=$_POST['password'];
					$user = User::getUser(null,"WHERE `username`='$username'");
					if(isset($user[0])){
						if(password_verify($password,$user[0]->password)){
							echo "login successful";
						}else{
						echo "password invalid";
						}
					}else{
						echo "user not found";
					}
				}else{
				if(isset($_POST['register'])){
					$username=$_POST['username'];
					$password=password_hash($_POST['password']);
					User::insertUser(new User($username,$password));
				}
			}
			break;
		}
	}
?>
