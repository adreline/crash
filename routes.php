<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
require Crash::$controller['app'];
require Crash::$controller['users'];
require Crash::$controller['admin'];
use Controller\Admin\Controller as AdminController;

use function Controller\App\process as app_process;
use function Controller\Users\enlist as users_enlist;
use function Controller\Users\logout as users_logout;
use function Controller\Users\view_profile as view_profile;


$forward = new Router();
/* Static routes */
$forward->route("/crash/", function(){
    app_process("home");
});
/* Users routes */
$forward->route("/crash/users/enlist", function(){
    users_enlist();
},"POST");
$forward->route("/crash/users/logout", function(){
    users_logout();
},"POST");
$forward->route("/crash/users/profile", function(){
    view_profile();
});
/* Admin routes */
//verify permission level 
if(isset($_SESSION['protagonist']) && $_SESSION['protagonist']->privelage){
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
}


?>
