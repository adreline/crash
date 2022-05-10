<?php
namespace Controller\Users;
use Crash\Crash as Crash;
use function Controller\App\process as redirect_home;
use Elements\User as User;
use Elements\Session as Session;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;

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
			$action = "/crash/users/scriptorium/publication/edit";
		}else{
			$publication = new Publication("",0,0,0,0);
			$action = "/crash/users/scriptorium/publication/new";
		}
		include Crash::$static_page["user/scriptorium/editor"];
	}
	public static function insertNewPublication($form){
		$pub = new Publication(
			$form['title'],
			$form['planned_length'],
			$form['status'],
			$form['users_id_user'],
			"1" //in the future, replace with actual fandom id fetch by $form['fandom_name']
		);

		if(!Publication::insertPublication($pub)){
			die(mysql_error);
		}
		
		redirect_home('home',function(){
			Crash::notify("success","Work published");
		  });	
	}
	/* leaflet management routes*/
	public static function showLeafOverview($publication_id){
		$publication = Publication::getPublication($publication_id)[0];
		$leafs = Publication::getPublicationLeafs($publication_id);
		include Crash::$static_page["user/scriptorium/leaf"];
	}
	public static function showLeafEditor($id_pub,$id_leaf=null){
		if(isset($id_leaf)){
			$leaf = Leaflet::getLeafletById($id_leaf);
			$action = "/crash/users/scriptorium/leaflet/edit";
		}else{
			$action = "/crash/users/scriptorium/leaflet/new";
		}
		$publication = Publication::getPublication($id_pub)[0];
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
		redirect_home('home',function(){
			Crash::notify("success","Page published");
		  });
	}
	public static function deleteLeaflet($id_leaf){
		if(!Leaflet::deleteLeaflet($id_leaf)){
			die(mysql_error);
		}
		redirect_home('home',function(){
			Crash::notify("success","Page deleted");
		  });
	}
	/* account management routes */
	public static function logout(){
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
	}
	public static function showDashboard(){
		include Crash::$static_page["user/dashboard"];
	}
}

?>
