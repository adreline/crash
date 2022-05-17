<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Session as Session;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;
use Elements\Fandom as Fandom;
use Elements\Kudo as Kudo;
use Elements\Comment as Comment;
/*
* This controller processes everything that has to do with users
*/
class Controller{

	/* comment management methods */
	public static function leaveComment($form){
		$comment = new Comment(
			$form['id_user'],
			$form['id_publication'],
			$form['body']
		);
		if(!Comment::insertComment($comment)){
			die(mysql_error);
		}else{
			$uri_redirect_back = Publication::getPublicationById($form['id_publication'])->uri;
			Crash::redirect("/crash/athenaeum/$uri_redirect_back");
		}
	}
	public static function deleteComment($id_comment,$uri_redirect_back){
		if(!Comment::deleteComment($id_comment)){
			die(mysql_error);
		}else{
			Crash::redirect("/crash/athenaeum/$uri_redirect_back");
		}
	}
	/* kudo management methods*/
	public static function leaveKudo($id_user,$id_publication){
		if(!Kudo::insertKudo($id_user,$id_publication)){
			die(mysql_error);
		}else{
			$uri_redirect_back = Publication::getPublicationById($id_publication)->uri;
			Crash::redirect("/crash/athenaeum/$uri_redirect_back");
		}
	}
	public static function withdrawKudo($id_user,$id_publication){
		if(!Kudo::deleteKudo($id_user,$id_publication)){
			die(mysql_error);
		}else{
			$uri = Publication::getPublicationById($id_publication)->uri;
			Crash::redirect("/crash/athenaeum/$uri");
		}
	}
	/* publications management methods */
	public static function showScriptorium(){
		include Crash::$static_page["user/scriptorium"];
	}
	public static function deletePublication($id_publication){
		//the constraint will fail if we attempt to delete a publication that has published chapters
		foreach(Publication::getPublicationLeafs($id_publication) as $leaf){
			if(!Leaflet::deleteLeaflet($leaf->id)){
				die(mysql_error);
			}
		}
		if(!Publication::deletePublication($id_publication)){
			die(mysql_error);
		}else{
			Crash::redirect("/crash/users/scriptorium");
		}
	}
	public static function showPublicationEditor($id_publication=null){
		if(isset($id_publication)){
			$publication = Publication::getPublicationById($id_publication);
			$fandom_name = Fandom::getFandomById($publication->fandoms_id_fandom)->friendly_name;
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
			foreach(Fandom::getActiveFandoms() as $fan){
				$proximity = levenshtein($fan->friendly_name, $form['fandom_name']);
				if($proximity<$best_proximity || !isset($best_proximity)){
					$best_proximity = $proximity;
					$best_fan = $fan;
				}
			}
			Crash::redirect("/crash/users/scriptorium/publication/editor",["title"=>"Fandom not found","message"=>"Did you mean: $best_fan->friendly_name?"]);
			
		}else{
			
			if($form['uri']==''){
				$form['uri']=str_replace(" ","-",$form['title']);
			}
			//uncomment these lines when upload_tmp_dir issue is fixed
			//$filename = Image::saveImageAsFile($_FILE['image']);
			//if(!isset($filename)) die("file upload failed");
			//if(!Image::insertImage(new Image($form['alt'],$filename))) die(mysql_error);

			$pub = new Publication(
				addslashes($form['title']),
				$form['uri'],
				$form['planned_length'],
				$form['status'],
				$form['users_id_user'],
				$fan->id,
				null,
				null,
				null, //replace with Image::getImageByFilename($filename)->id when upload_tmp_dir issue is fixed
				htmlspecialchars(addslashes($form['prompt']),ENT_QUOTES),
				null
			);
			
			if(!Publication::insertPublication($pub)) die(mysql_error);
			Crash::redirect("/crash/users/scriptorium");
		}
	
	}
	public static function updatePublication($form){
		//find fandom by name 
		$fan = Fandom::getFandomByName($form['fandom_name']);
		if($fan instanceof Fandom){
			$pub = new Publication(
				addslashes($form['title']),
				$form['uri'],
				$form['planned_length'],
				$form['status'],
				$form['users_id_user'],
				$fan->id,
				null,
				null,
				null, //replace with an image in the future
				htmlspecialchars(addslashes($form['prompt']),ENT_QUOTES),
				$form['id_publication']
			);
			if(!Publication::updatePublication($pub)){
				die(mysql_error);
			}
			
			Crash::redirect("/crash/users/scriptorium");
		}else{
			Crash::redirect("/crash/users/scriptorium",["title"=>"fail","message"=>"Fandom does not exist"]);
		}
		
	}
	/* leaflet management methods*/
	public static function showLeafOverview($publication_id){
		$publication = Publication::getPublicationById($publication_id);
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
		$publication = Publication::getPublicationById($id_pub);
		include Crash::$static_page["user/scriptorium/leaf/editor"];
	}
	public static function insertNewLeaf($form){
		$word_count=sizeof(explode(" ",$form["body"]));
		$leaf = new Leaflet(
			addslashes($form['title']),
			htmlspecialchars(addslashes($form['body']),ENT_QUOTES),
			$word_count,
			$form['id_publication']
		);
		if(!Leaflet::insertLeaflet($leaf)){
			die(mysql_error);
		}
		$id=$form['id_publication'];
		Crash::redirect("/crash/users/scriptorium/leaflet?id=$id");

	}
	public static function updateLeaf($form){
		
		$word_count=sizeof(explode(" ",$form["body"]));
		$leaf = new Leaflet(
			addslashes($form['title']),
			htmlspecialchars(addslashes($form['body']),ENT_QUOTES),
			$word_count,
			$form['id_publication'],
			null,
			null,
			$form['id_leaf']
		);
		if(!Leaflet::updateLeaflet($leaf)){
			die(mysql_error);
		}
		$id_pub=$form['id_publication'];
		$id_leaf=$form['id_leaf'];
		Crash::redirect("/crash/users/scriptorium/leaflet/editor?id_pub=$id_pub&id_leaf=$id_leaf");
	}
	public static function deleteLeaflet($id_leaf){
		if(!Leaflet::deleteLeaflet($id_leaf)){
			die(mysql_error);
		}
		Crash::redirect("/crash/users/scriptorium");
	}
	/* account management methods */
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
		Crash::redirect("/crash/");
	}
	public static function enlist(){
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
							Crash::redirect("/crash/");
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
					if(!User::insertUser(new User($username,$password))){
						die(mysql_error);
					}else{
					Crash::redirect("/crash/",["title"=>"success","message"=>"Your account was created"]);
					}
				}
			}	
	}
	public static function showDashboard(){
		include Crash::$static_page["user/dashboard"];
	}
	/* fandom request methods */
	public static function showFandomForm(){
		include Crash::$static_page["fandom/request"];
	}
	public static function insertFandom($form){
		$form['friendly_name']=addslashes($form['friendly_name']);
		if($form['name']=="") $form['name'] = str_replace(" ", "-", $form['friendly_name']);

		$fandom = new Fandom($form['friendly_name'],$form['name']);
		if(!Fandom::insertFandom($fandom)) die(mysql_error());
		Crash::redirect("/crash/users/scriptorium",["title"=>"success","message"=>"Your request has been submited"]);
	}
}

?>
