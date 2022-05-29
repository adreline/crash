<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use Elements as E;
use Elements\Validator as Validator;
/*
* This controller processes everything that has to do with users
*/
class Controller{

	/* account management methods */
	public static function changeAvatar($form){
		$user = $_SESSION['protagonist'];
		if(strlen($_FILES['image']['tmp_name'])>0){
			$filename = E\Image::saveImageAsFile($_FILES['image']);
			if(!isset($filename)) Crash::error(500,"failed to upload an image");
			if(strlen($form['alt'])<2) $form['alt'] = "alt";
			if(!E\Image::insertImage(new E\Image($form['alt'],$filename))) Crash::error(500,"internal server error");
			$user->images_id_image = E\Image::getImageByFilename($filename)->id;
			
		}else{
			$user->images_id_image = $_SESSION['protagonist']->images_id_image;
		}
		if(!E\User::updateUser($user)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/users/profile");
	}
	public static function showAvatarForm(){
		global $head;
		$head->title = "change your avatar - account setting - Crash";
		$head->desc = "change your profile picture";
		$head->robots = "noindex,follow";
		include Crash::$static_page['user/avatar'];
	}
	public static function showPasswordForm(){
		global $head;
		$head->title = "change your password - account setting - Crash";
		$head->desc = "change your account password";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/password"];

	}
	public static function changePassword($form){
		$active_user=$_SESSION['protagonist'];
		$active_user->password = password_hash($form['new_pass'], PASSWORD_BCRYPT, array('cost'=>10));
		if(!E\User::updateUser($active_user)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/users/profile",["title"=>"success","message"=>"Your password has been changed"]);
	}
	public static function showUsernameForm(){
		global $head;
		$head->title = "change your username - account setting - Crash";
		$head->desc = "change your profile username";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/username"];

	}
	public static function changeUsername($form){
		$active_user=$_SESSION['protagonist'];
		$active_user->username = $form['new_username'];
		if(!E\User::updateUser($active_user)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/users/profile",["title"=>"success","message"=>"Your username has been changed"]);
	}
	public static function logout(){
		$_SESSION['protagonist']=null;
		$session = E\Session::getSession(session_id());
		if(isset($session)) E\Session::deleteSession($session->id);
		session_destroy();
		Crash::redirect("/crash/");
	}
	public static function deleteAccount($id_account){
		//users have constraints on publication and comments so we can't actually delete the account. we set it to inactive
		if(!E\User::deleteUser($id_account)) Crash::error(500,"internal server error");
		Controller::logout();
	}
	public static function confirmDeletion(){
		global $head;
		$head->title = "delete your account - account setting - Crash";
		$head->desc = "please confirm deletion of your account";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/delete"];
	}
	public static function enlist(){
				if(isset($_POST['login'])){
					//attempt to log the user in
					$username=$_POST['username'];
					$password=$_POST['password'];
					if(!Validator::validatePassword($password) || !Validator::validateUsername($username)) Crash::redirect("/crash/",["title"=>"fail","message"=>"input is incorrect or contains forbidden characters"]);
					$user = E\User::getActiveUserByName($username);
					if(!isset($user)) Crash::redirect("/crash/",["title"=>"fail","message"=>"No user with such name was found"]);
					if(!password_verify($password,$user->password)) Crash::redirect("/crash/",["title"=>"fail","message"=>"Password was incorrect"]);
					//login successful, redirect back to home and display a modal msg
					$_SESSION['protagonist']=$user;
					E\Session::insertSession(new E\Session(session_id(),$user->id));
					Crash::redirect("/crash/");
				}else{
				if(isset($_POST['register'])){
					$username=$_POST['username'];
					if(!Validator::validatePassword($_POST['password']) || !Validator::validateUsername($username)) Crash::redirect("/crash/",["title"=>"fail","message"=>"input is incorrect or contains forbidden characters"]);
					$password=password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>10));
					if(!E\User::insertUser(new E\User($username,$password))) Crash::error(500,"internal server error");
					Crash::redirect("/crash/",["title"=>"success","message"=>"Your account was created"]);
				}
			}	
	}
	public static function showDashboard(){
		$pfp = E\Image::getImageById($_SESSION['protagonist']->images_id_image);
		$kudo_count = E\Kudo::countReceivedUserKudosById($_SESSION['protagonist']->id);
		$work_count = E\User::getUserPublicationsCount($_SESSION['protagonist']->id);
		global $head;
		$head->title = $_SESSION['protagonist']->username." - Crash";
		$head->desc = "manage your account";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/dashboard"];
	}
}

?>
