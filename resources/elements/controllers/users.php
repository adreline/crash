<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use Elements as E;
use Elements\Validator as Validator;
/*
* This controller processes everything that has to do with users
*/
class Controller{

	/* comment management methods */
	public static function leaveComment($form){
		if(!is_numeric($form['id_user'])||!is_numeric($form['id_publication'])) Crash::redirect("/crash/",['title'=>'fail','message'=>'input is incorrect']);

		$comment = new E\Comment(
			$form['id_user'],
			$form['id_publication'],
			Validator::sanitizeGeneric($form['body'])
		);
		if(!E\Comment::insertComment($comment)) Crash::error(500,"internal server error");
		$uri_redirect_back = E\Publication::getPublicationById($form['id_publication'])->uri;
		Crash::redirect("/crash/athenaeum/$uri_redirect_back");
	}
	public static function deleteComment($id_comment,$uri_redirect_back){
		if(!E\Comment::deleteComment($id_comment)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/athenaeum/$uri_redirect_back");
		
	}
	/* kudo management methods*/
	public static function leaveKudo($id_user,$id_publication){
		if(!E\Kudo::insertKudo($id_user,$id_publication)) Crash::error(500,"internal server error");
		$uri_redirect_back = E\Publication::getPublicationById($id_publication)->uri;
		Crash::redirect("/crash/athenaeum/$uri_redirect_back");
	}
	public static function withdrawKudo($id_user,$id_publication){
		if(!E\Kudo::deleteKudo($id_user,$id_publication)) Crash::error(500,"internal server error");
		$uri = E\Publication::getPublicationById($id_publication)->uri;
		Crash::redirect("/crash/athenaeum/$uri");
	}
	/* publications management methods */
	public static function showScriptorium(){
		global $head;
		$head->title = "author workbench - Crash";
		$head->desc = "Manage your works in one place";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/scriptorium"];
	}
	public static function deletePublication($id_publication){
		//the constraint will fail if we attempt to delete a publication that has published chapters
		foreach(E\Publication::getPublicationLeafs($id_publication) as $leaf){
			if(!E\Leaflet::deleteLeaflet($leaf->id)) Crash::error(500,"internal server error");
		}
		//the constraint will fail if we attempt to delete a publication that has tags attached
		foreach(E\Tag::getPublicationTags($id_publication) as $tag){
			E\Tag::unattachTag($id_publication,$tag->id);
		}
		$pub = E\Publication::getPublicationById($id_publication);
		if(!E\Publication::deletePublication($id_publication)) Crash::error(500,"internal server error");
		if($pub->images_id_image != 1){
			if(!E\Image::deleteImage($pub->images_id_image)) Crash::error(500,"internal server error");
		}
		Crash::redirect("/crash/users/scriptorium");
	}
	public static function showPublicationEditor($id_publication=null){
		$tags = "";
		if(isset($id_publication)){
			$publication = E\Publication::getPublicationById($id_publication);
			$fandom_name = E\Fandom::getFandomById($publication->fandoms_id_fandom)->friendly_name;
			try{
				foreach(E\Tag::getPublicationTags($id_publication) as $tag){
					$tags.=$tag->friendly_name.",";
				}
				$tags = substr($tags, 0, strlen($tags)-1);
			}catch(Exception|Throwable){}
			
			$action = "/crash/users/scriptorium/publication/edit";
		}else{
			$publication = new E\Publication();
			$fandom_name = "";
			$action = "/crash/users/scriptorium/publication/new";
		}
		global $head;
		$head->title = "work editor - author workbench - Crash";
		$head->desc = "Create or update your works";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/scriptorium/editor"];
	}
	public static function insertNewPublication($form){

		//find fandom by name 
		$fan = E\Fandom::getFandomByName($form['fandom_name']);
		
		if(!($fan instanceof E\Fandom)){
			//maybe a typo, find closest one using levenshtein algorithm
			$best_proximity=null;
			$best_fan=null;
			foreach(E\Fandom::getActiveFandoms() as $fan){
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
			$id_image=1;
			if(strlen($_FILES['image']['tmp_name'])>0){
				$filename = E\Image::saveImageAsFile($_FILES['image']);
				if(!isset($filename)) Crash::error(500,"failed to upload an image");
				if(strlen($form['alt'])<2) $form['alt'] = "alt";
				if(!E\Image::insertImage(new E\Image($form['alt'],$filename))) Crash::error(500,"internal server error");
				$id_image=E\Image::getImageByFilename($filename)->id;
			}
			$pub = new E\Publication(
				addslashes($form['title']),
				$form['uri'],
				$form['planned_length'],
				$form['status'],
				$form['users_id_user'],
				$fan->id,
				null,
				null,
				$id_image, 
				htmlspecialchars(addslashes($form['prompt']),ENT_QUOTES),
				null
			);
			
			if(!E\Publication::insertPublication($pub)) Crash::error(500,"internal server error");
			$id_publication = E\Publication::getPublicationByUrl($pub->uri)->id;
			try{
				$tags = explode(',',$form['tags']);
				foreach($tags as $tag_name){
					$tag=trim($tag_name);
					if(!E\Tag::tagExists($tag_name)) E\Tag::insert(new E\Tag($tag_name,str_replace(' ','-',$tag_name)));
					$id_tag = E\Tag::getTagByName($tag_name)->id;
					E\Tag::attachTag($id_publication,$id_tag);	
				}
			}catch(Exception|Throwable){}
			Crash::redirect("/crash/users/scriptorium");
		}
	
	}
	public static function updatePublication($form){
		//find fandom by name 
		$fan = E\Fandom::getFandomByName($form['fandom_name']);
		if(!($fan instanceof E\Fandom)) Crash::redirect("/crash/users/scriptorium",["title"=>"fail","message"=>"Fandom does not exist"]);
		if(strlen($_FILES['image']['tmp_name'])>0){
			$filename = E\Image::saveImageAsFile($_FILES['image']);
			if(!isset($filename)) Crash::error(500,"failed to upload an image");
			if(strlen($form['alt'])<2) $form['alt'] = "alt";
			if(!E\Image::insertImage(new E\Image($form['alt'],$filename))) Crash::error(500,"internal server error");
			$id_image = E\Image::getImageByFilename($filename)->id;
		}else{
			$id_image = E\Publication::getPublicationById($form['id_publication'])->images_id_image;
		}

		$pub = new E\Publication(
			addslashes($form['title']),
			$form['uri'],
			$form['planned_length'],
			$form['status'],
			$form['users_id_user'],
			$fan->id,
			null,
			null,
			$id_image,
			htmlspecialchars(addslashes($form['prompt']),ENT_QUOTES),
			$form['id_publication']
			);
		if(!E\Publication::updatePublication($pub)) Crash::error(500,"internal server error");
		try{
			$tags = explode(',',$form['tags']);
			$old_tags = array();
			foreach(E\Tag::getPublicationTags($form['id_publication']) as $tag){
				$old_tags[]=$tag->friendly_name;
			}
			$tags_to_unattach = array_diff($old_tags,$tags);
			unset($old_tags);
			foreach($tags_to_unattach as $tag_name){
				$id_tag = E\Tag::getTagByName($tag_name)->id;
				E\Tag::unattachTag($form['id_publication'],$id_tag);
			}
			unset($tags_to_unattach);
			foreach($tags as $tag_name){
				$tag=trim($tag_name);
				if(!E\Tag::tagExists($tag_name)) E\Tag::insert(new E\Tag($tag_name,str_replace(' ','-',$tag_name)));
				$id_tag = E\Tag::getTagByName($tag_name)->id;
				E\Tag::attachTag($form['id_publication'],$id_tag);	
			}
			}catch(Exception|Throwable){}
			Crash::redirect("/crash/users/scriptorium");	
	}
	/* leaflet management methods*/
	public static function showLeafOverview($publication_id){
		$publication = E\Publication::getPublicationById($publication_id);
		$leafs = E\Publication::getPublicationLeafs($publication_id);
		global $head;
		$head->title = "chapters in $publication->title - author workbench - Crash";
		$head->desc = "Manage chapters in $publication->title";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/scriptorium/leaf"];
	}
	public static function showLeafEditor($id_pub,$id_leaf=null){
		if(isset($id_leaf)){
			$leaf = E\Leaflet::getLeafletById($id_leaf);
			$leaf->body = htmlspecialchars_decode($leaf->body, ENT_QUOTES);
			$action = "/crash/users/scriptorium/leaflet/edit";
		}else{
			$action = "/crash/users/scriptorium/leaflet/new";
		}
		$publication = E\Publication::getPublicationById($id_pub);
		global $head;
		$head->title = "chapter editor - chapter in $publication->title - author workbench - Crash";
		$head->desc = "Manage chapter in $publication->title";
		$head->robots = "noindex,follow";
		include Crash::$static_page["user/scriptorium/leaf/editor"];
	}
	public static function insertNewLeaf($form){
		$word_count=sizeof(explode(" ",$form["body"]));
		$leaf = new E\Leaflet(
			addslashes($form['title']),
			htmlspecialchars(addslashes($form['body']),ENT_QUOTES),
			$word_count,
			$form['id_publication']
		);
		if(!E\Leaflet::insertLeaflet($leaf)) Crash::error(500,"internal server error");
		$id=$form['id_publication'];
		Crash::redirect("/crash/users/scriptorium/leaflet?id=$id");

	}
	public static function updateLeaf($form){
		
		$word_count=sizeof(explode(" ",$form["body"]));
		$leaf = new E\Leaflet(
			addslashes($form['title']),
			htmlspecialchars(addslashes($form['body']),ENT_QUOTES),
			$word_count,
			$form['id_publication'],
			null,
			null,
			$form['id_leaf']
		);
		if(!E\Leaflet::updateLeaflet($leaf)) Crash::error(500,"internal server error");
		$id_pub=$form['id_publication'];
		$id_leaf=$form['id_leaf'];
		Crash::redirect("/crash/users/scriptorium/leaflet/editor?id_pub=$id_pub&id_leaf=$id_leaf");
	}
	public static function deleteLeaflet($id_leaf){
		if(!E\Leaflet::deleteLeaflet($id_leaf)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/users/scriptorium");
	}
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
	/* fandom request methods */
	public static function showFandomForm(){
		global $head;
		$head->title = "request new fandom - Crash";
		$head->desc = "you can submit new fandom requests here";
		$head->robots = "noindex,follow";
		include Crash::$static_page["fandom/request"];
	}
	public static function insertFandom($form){
		$form['friendly_name']=addslashes($form['friendly_name']);
		if($form['name']=="") $form['name'] = str_replace(" ", "-", $form['friendly_name']);

		$fandom = new E\Fandom($form['friendly_name'],$form['name']);
		if(!E\Fandom::insertFandom($fandom)) Crash::error(500,"internal server error");
		Crash::redirect("/crash/users/scriptorium",["title"=>"success","message"=>"Your request has been submited"]);
	}
}

?>
