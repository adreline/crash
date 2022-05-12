<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Session as Session;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;
use Elements\Fandom as Fandom;

/*
* This controller processes everything that has to do with users
*/
class Controller{

	/* publications management routes */
	public static function showScriptorium(){
		include Crash::$static_page["user/scriptorium"];
	}
	public static function showPublicationEditor($id_publication=null){
		if(isset($id_publication)){
			$publication = Publication::getPublication($id_publication);
			$fandom_name = Fandom::getFandom($publication->fandoms_id_fandom)->friendly_name;
			$action = "/crash/users/scriptorium/publication/edit";
		}else{
			$publication = new Publication();
			$fandom_name = "";
			$action = "/crash/users/scriptorium/publication/new";
		}
		include Crash::$static_page["user/scriptorium/editor"];
	}
	public static function insertNewPublication($form){

		//find fandom by name 
		$fan = Fandom::getFandomByName($form['fandom_name']);

		if(!($fan instanceof Fandom)){
			//maybe a typo, find closest one using levenshtein algorithm
			$best_proximity=null;
			$best_fan=null;
			foreach(Fandom::getFandom() as $fan){
				$proximity = levenshtein($fan->friendly_name, $form['fandom_name']);
				if($proximity<$best_proximity || !isset($best_proximity)){
					$best_proximity = $proximity;
					$best_fan = $fan;
				}
			}
			Crash::redirect("/crash/users/scriptorium/publication/editor",["title"=>"Fandom not found","message"=>"Did you mean: $best_fan->friendly_name"]);
			
		}else{
			$pub = new Publication(
				$form['title'],
				$form['uri'],
				$form['planned_length'],
				$form['status'],
				$form['users_id_user'],
				$fan->id
			);
	
			if(!Publication::insertPublication($pub)){
				die(mysql_error);
			}
			Crash::redirect("/crash/users/scriptorium",["title"=>"success","message"=>"Work published"]);
		}
	
	}
	public static function updatePublication($form){
		$pub = new Publication(
			$form['title'],
			$form['uri'],
			$form['planned_length'],
			$form['status'],
			$form['users_id_user'],
			"1", //in the future, replace with actual fandom id fetch by $form['fandom_name']
			null,
			null,
			$form['id_publication']
		);
		if(!Publication::updatePublication($pub)){
			die(mysql_error);
		}
		
		Crash::redirect("/crash/users/scriptorium",["title"=>"success","message"=>"Work edited"]);
	}
	/* leaflet management routes*/
	public static function showLeafOverview($publication_id){
		$publication = Publication::getPublication($publication_id);
		$leafs = Publication::getPublicationLeafs($publication_id);
		include Crash::$static_page["user/scriptorium/leaf"];
	}
	public static function showLeafEditor($id_pub,$id_leaf=null){
		if(isset($id_leaf)){
			$leaf = Leaflet::getLeafletById($id_leaf);
			$leaf->body = htmlspecialchars_decode($leaf->body, ENT_QUOTES);
			$action = "/crash/users/scriptorium/leaflet/edit";
		}else{
			$action = "/crash/users/scriptorium/leaflet/new";
		}
		$publication = Publication::getPublication($id_pub);
		include Crash::$static_page["user/scriptorium/leaf/editor"];
	}
	public static function insertNewLeaf($form){
		$leaf = new Leaflet(
			null,
			htmlspecialchars($form['body'],ENT_QUOTES),
			$form['id_publication']
		);
		if(!Leaflet::insertLeaflet($leaf)){
			die(mysql_error);
		}
		$id=$form['id_publication'];
		Crash::redirect("/crash/users/scriptorium/leaflet?id=$id",["title"=>"success","message"=>"Page published"]);

	}
	public static function updateLeaf($form){
		$leaf = new Leaflet(
			$form['id_leaf'],
			htmlspecialchars($form['body'],ENT_QUOTES),
			$form['id_publication']
		);
		if(!Leaflet::updateLeaflet($leaf)){
			die(mysql_error);
		}
		$id_pub=$form['id_publication'];
		$id_leaf=$form['id_leaf'];
		Crash::redirect("/crash/users/scriptorium/leaflet/editor?id_pub=$id_pub&id_leaf=$id_leaf",["title"=>"success","message"=>"Page edited"]);
	}
	public static function deleteLeaflet($id_leaf){
		if(!Leaflet::deleteLeaflet($id_leaf)){
			die(mysql_error);
		}
		Crash::redirect("/crash/users/scriptorium",["title"=>"success","message"=>"Page deleted"]);

	}
	/* account management routes */
	public static function showPasswordForm(){
		include Crash::$static_page["user/password"];

	}
	public static function changePassword($form){
		$active_user=$_SESSION['protagonist'];
		$active_user->password = password_hash($form['new_pass'], PASSWORD_BCRYPT, array('cost'=>10));
		if(!User::updateUser($active_user)){
			die(mysql_error);
		}
		Crash::redirect("/crash/users/profile",["title"=>"success","message"=>"Your password has been changed"]);
	}
	public static function showUsernameForm(){
		include Crash::$static_page["user/username"];

	}
	public static function changeUsername($form){
		$active_user=$_SESSION['protagonist'];
		$active_user->username = $form['new_username'];
		if(!User::updateUser($active_user)){
			die(mysql_error);
		}
		Crash::redirect("/crash/users/profile",["title"=>"success","message"=>"Your username has been changed"]);
	}
	public static function logout(){
		$_SESSION['protagonist']=null;
		$session = Session::getSession(session_id());
		if(isset($session)){
			Session::deleteSession($session->id);
		}
		session_destroy();
		Crash::redirect("/crash/",["title"=>"Loged out","message"=>"You have been logged out"]);
	}
	public static function enlist($req=null){
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
							Crash::redirect("/crash/",["title"=>"success","message"=>"Login successful"]);
						}else{
							Crash::redirect("/crash/",["title"=>"fail","message"=>"Password was incorrect"]);
						}
					}else{
						Crash::redirect("/crash/",["title"=>"fail","message"=>"No user with such name was found"]);
					}
				}else{
				if(isset($_POST['register'])){
					$username=$_POST['username'];
					$password=password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost'=>10));
					User::insertUser(new User($username,$password));
					Crash::redirect("/crash/",["title"=>"success","message"=>"Your account was created"]);
				}
			}	
	}
	public static function showDashboard(){
		include Crash::$static_page["user/dashboard"];
	}
}

?>
