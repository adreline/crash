<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
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
        UsersController::insertNewPublication($_REQUEST);
    },"POST");
    
}

?>
