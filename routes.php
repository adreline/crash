<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
use Elements\Publication as Publication;
require Crash::$controller['app'];
require Crash::$controller['users'];
require Crash::$controller['admin'];
use Controller\Admin\Controller as AdminController;
use Controller\Users\Controller as UsersController;

use function Controller\App\process as app_process;



$forward = new Router();
/* Static routes */
$forward->route("/crash/", function(){
    app_process("home");
});
/* Admin routes */
if(isset($_SESSION['protagonist']) && $_SESSION['protagonist']->privelage){//verify permission level 
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
        AdminController::updatePage($_REQUEST);
    },"POST");
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::showPageEditor();
    });
    $forward->route("/crash/admin/pages/new", function(){
        AdminController::insertNewPage($_REQUEST);
    },"POST");
    $forward->route("/crash/admin/pages/delete", function(){
        AdminController::deletePage($_GET['id']);
    });
}
/* user specific routes */
if(isset($_SESSION['protagonist'])){//verify if user is logged in
    $forward->route("/crash/users/enlist", function(){
        UsersController::enlist();
    },"POST");
    $forward->route("/crash/users/logout", function(){
        UsersController::logout();
    },"POST");
    $forward->route("/crash/users/profile", function(){
        UsersController::showDashboard();
    });
    $forward->route("/crash/users/scriptorium", function(){
        UsersController::showScriptorium();
    });
    $forward->route("/crash/users/scriptorium/publication/editor", function(){
        UsersController::showPublicationEditor();
    });
    $forward->route("/crash/users/scriptorium/publication/new",function(){
        //verify if id's have not been tampered with 
        if($_REQUEST['users_id_user']==$_SESSION['protagonist']->id){
            UsersController::insertNewPublication($_REQUEST);
        }else{
            Crash::error(403,"You don't have permission to publish this publication");
        }
        
    },"POST");
    $forward->route("/crash/users/scriptorium/leaflet", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id == Publication::getPublication($_GET['id'])[0]->users_id_user){
            UsersController::showLeafOverview($_GET['id']);
        }else{
            Crash::error(403,"You aren't an author of this publication");
        }
        
    });
    $forward->route("/crash/users/scriptorium/leaflet/editor", function(){
        //verify that supplied publication id is that of a publication owned by current user
        if($_SESSION['protagonist']->id == Publication::getPublication($_GET['id_pub'])[0]->users_id_user){ 
            UsersController::showLeafEditor($_GET['id_pub'],$_GET['id_leaf']);
        }else{
            Crash::error(403,"You aren't an author of this publication");
        }
        
    });
    $forward->route("/crash/users/scriptorium/leaflet/new", function(){
        //TODO verify that supplied publication id is that of a publication owned by current user
        var_dump($_REQUEST);
        die();
    });
}

?>
