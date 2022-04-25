<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use function Controller\App\process as app_process;
use Elements\User as User;
/*
* This controller processes register and login
*/
	function process($req=null, $template='default'){
		echo "Hello";
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
							//login successful, redirect back to home and display a modal msg
							app_process("home", function(){
								Crash::notify("Success","Login successful");
							});
						}else{
						app_process("home", function(){
								Crash::notify("Fail","Password was incorrect");
							});
						}
					}else{
						app_process("home", function(){
								Crash::notify("Fail","No user with such name was found");
							});
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
				Crash::error(404, "Thrown in Controller\Users. Requested url: $req");
			break;
		}
	}
?>
