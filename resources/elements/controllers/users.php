<?php
use Crash\Crash as Crash;
require_once Crash::$element['user'];
use function Controller\App\process as app_process;
use Elements\User as User;
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
							//login successful, redirect back to home
							$modal="login successful";
							require Crash::$controller['app'];
							app_process("/crash/");
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
			default:
				include Crash::$static_page['404'];
			break;
		}
	}
?>
