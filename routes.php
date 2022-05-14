<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;

require Crash::$controller['app'];
require Crash::$controller['users'];
require Crash::$controller['admin'];
require Crash::$controller['athenaeum'];
use Controller\Admin\Controller as AdminController;
use Controller\Users\Controller as UsersController;
use Controller\Reader\Controller as ReaderController;

use function Controller\App\process as app_process;



$forward = new Router();
/* Static routes */
$forward->route("/crash/", function(){
    app_process("home");
});
/* Reader routes*/
$forward->route("/crash/athenaeum",function($title){
    $pub = Publication::getPublicationByUrl($title);
    ReaderController::showReader($pub);
});
/* Admin routes */
if(isset($_SESSION['protagonist']) && $_SESSION['protagonist']->administrator){//verify permission level 
    $forward->route("/crash/admin", function(){
            AdminController::showPanel();
    });
    $forward->route("/crash/admin/pages", function(){
        AdminController::showPagesManager();
    });
    $forward->route("/crash/admin/pages/edit", function(){
        AdminController::showPageEditor($_GET['id']);
    });
    $forward->route("/crash/admin/pages/edit", function(){
        AdminController::updatePage($_POST);
    },"POST");
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::showPageEditor();
    });
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::insertNewPage($_POST);
    },"POST");
    $forward->route("/crash/admin/pages/delete", function(){
        AdminController::deletePage($_GET['id']);
    });
}
/* user specific routes */
//this route is used to log in users so we don't verify anything
$forward->route("/crash/users/enlist", function(){
    UsersController::enlist();
},"POST");

if(isset($_SESSION['protagonist'])){//verify if user is logged in
    /* comment management routes */
    $forward->route("/crash/athenaeum/comment/post",function(){
        //verify if id_user is that of the current logged in user
        if($_POST['id_user']==$_SESSION['protagonist']->id){
            UsersController::leaveComment($_POST);
        }else{
            Crash::error(403,"This action was unauthorized");
        }
    },"POST");
    /* kudo management routes*/
    $forward->route("/crash/athenaeum/kudo/give", function(){
        //verify if id_user is that of the current logged in user
        if($_GET['id_user']==$_SESSION['protagonist']->id){
            UsersController::leaveKudo($_GET['id_user'],$_GET['id_publication']);
        }else{
            Crash::error(403,"This action was unauthorized");
        }
    });
    $forward->route("/crash/athenaeum/kudo/withdraw",function(){
        //verify if id_user is that of the current logged in user
        if($_GET['id_user']==$_SESSION['protagonist']->id){
            UsersController::withdrawKudo($_GET['id_user'],$_GET['id_publication']);
        }else{
            Crash::error(403,"This action was unauthorized");
        }
    });
    /** user account management routes*/
    $forward->route("/crash/users/password",function(){
        UsersController::showPasswordForm();
    });
    $forward->route("/crash/users/password",function(){
        //verify if user is that of the current logged in user
        if($_POST['id_user'] == $_SESSION['protagonist']->id){
            UsersController::changePassword($_POST);
        }else{
            Crash::error(403,"Unauthorised password change. This incident will be reported.");
        }
        
    },"POST");
    $forward->route("/crash/users/username",function(){
        UsersController::showUsernameForm();
    });
    $forward->route("/crash/users/username",function(){
        //verify if user is that of the current logged in user
        if($_POST['id_user'] == $_SESSION['protagonist']->id){
            UsersController::changeUsername($_POST);
        }else{
            Crash::error(403,"Unauthorised username change. This incident will be reported.");
        }
        
    },"POST");
    $forward->route("/crash/users/logout", function(){
        UsersController::logout();
    },"POST");
    $forward->route("/crash/users/profile", function(){
        UsersController::showDashboard();
    });
    /** publication management routes */
    $forward->route("/crash/users/scriptorium", function(){
        UsersController::showScriptorium();
    });
    $forward->route("/crash/users/scriptorium/publication/delete", function(){
        if($_SESSION['protagonist']->id == Publication::getPublicationById($_GET['id_pub'])->users_id_user){
            UsersController::deletePublication($_GET['id_pub']);
        }else{
            Crash::error(403,"You aren't an author of this publication"); 
        }
    });
    $forward->route("/crash/users/scriptorium/publication/editor", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if(isset($_GET['id_pub'])){
            if($_SESSION['protagonist']->id == Publication::getPublicationById($_GET['id_pub'])->users_id_user){
                UsersController::showPublicationEditor($_GET['id_pub']);
            }else{
                Crash::error(403,"You aren't an author of this publication");
            }
        }else{
            UsersController::showPublicationEditor();
        }

        
    });
    $forward->route("/crash/users/scriptorium/publication/new",function(){
        //verify if id's have not been tampered with 
        if($_REQUEST['users_id_user']==$_SESSION['protagonist']->id){
            UsersController::insertNewPublication($_POST);
        }else{
            Crash::error(403,"You don't have permission to publish this publication");
        }
        
    },"POST");
    $forward->route("/crash/users/scriptorium/publication/edit",function(){
        //verify if id's have not been tampered with 
        if($_REQUEST['users_id_user']==$_SESSION['protagonist']->id){
            UsersController::updatePublication($_POST);
        }else{
            Crash::error(403,"You don't have permission to edit this publication");
        }
        
    },"POST");
    /** leaflet management routes */
    $forward->route("/crash/users/scriptorium/leaflet", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id == Publication::getPublicationById($_GET['id'])->users_id_user){
            UsersController::showLeafOverview($_GET['id']);
        }else{
            Crash::error(403,"You aren't an author of this publication");
        }
        
    });
    $forward->route("/crash/users/scriptorium/leaflet/editor", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id == Publication::getPublicationById($_GET['id_pub'])->users_id_user){ 
            UsersController::showLeafEditor($_GET['id_pub'],$_GET['id_leaf']);
        }else{
            Crash::error(403,"You aren't an author of this publication");
        }
        
    });
    $forward->route("/crash/users/scriptorium/leaflet/new", function(){
        //TODO verify that supplied publication id is that of a publication owned by current user 
        if($_SESSION['protagonist']->id == Publication::getPublicationById($_POST['id_publication'])->users_id_user){
            UsersController::insertNewLeaf($_POST);
        }else{
            Crash::error(403,"You aren't an author of this publication");
        }
        
    }, "POST");
    $forward->route("/crash/users/scriptorium/leaflet/delete", function(){
        //verify that supplied publication id is that of a publication owned by current user and that the leaflet belongs to that publication
        $pub = Publication::getPublicationById($_GET['id_pub']);
        $user = $_SESSION['protagonist'];
        $leaf = Leaflet::getLeafletById($_GET['id_leaf']);
        if($user->id == $pub->users_id_user && $leaf->publications_id_publication == $pub->id){ 
            UsersController::deleteLeaflet($_GET['id_leaf']);
        }else{
            Crash::error(403,"You aren't an author of this publication or the page does not belong to this publication");
        }
    });
    $forward->route("/crash/users/scriptorium/leaflet/edit", function(){
        //verify that supplied publication id is that of a publication owned by current user and that the leaflet belongs to that publication
        $pub = Publication::getPublicationById($_POST['id_publication']);
        $user = $_SESSION['protagonist'];
        $leaf = Leaflet::getLeafletById($_POST['id_leaf']);
        if($user->id == $pub->users_id_user && $leaf->publications_id_publication == $pub->id){
            UsersController::updateLeaf($_POST); 
         }else{
            Crash::error(403,"You aren't an author of this publication or the page does not belong to this publication");
        }
        
    },"POST");
}

?>
