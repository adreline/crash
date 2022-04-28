<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use function Controller\App\process as redirect_home;
use Elements\User as User;
use Elements\Session as Session;
/*
* This controller processes everything that has to do with users
*/
	function view_profile(){
		redirect_home('home',function(){
			Crash::notify("Nope","Not yet implemented");
		});
	}
	function logout(){
		$_SESSION['protagonist']=null;
		$session = Session::getSession(session_id());
		if(isset($session)){
			Session::deleteSession($session->id);
		}
		session_destroy();
		redirect_home('home',function(){
			Crash::notify("Loged out","You have been logged out");
		});
	}
	function enlist($req=null){
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
							
							$_SESSION['protagonist']=$user[0];
							Session::insertSession(new Session(session_id(),$user[0]->id));
							redirect_home("home", function(){								
								Crash::notify("Success","Login successful");
							});
						}else{
							redirect_home("home", function(){
								Crash::notify("Fail","Password was incorrect");
							});
						}
					}else{
						redirect_home("home", function(){
								Crash::notify("Fail","No user with such name was found");
							});
					}
				}else{
				if(isset($_POST['register'])){
					$username=$_POST['username'];
					$password=password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>10));
					User::insertUser(new User($username,$password));
					redirect_home("home", function(){
						Crash::notify("Success","Your account was created");
					});
				}
			}
			break;
			default:
				Crash::error(404, "Thrown in Controller\Users. Requested url: $req");
			break;
		}
	}
?>
