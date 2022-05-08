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
});
$forward->route("/crash/users/logout", function(){
    users_logout();
});
$forward->route("/crash/users/profile", function(){
    view_profile();
});
/* Admin routes */
$forward->route("/crash/admin", function(){
        //verify permission level
        //$prot = $_SESSION['protagonist'];  
        //if(isset($prot) && $prot->privelage){
            AdminController::showPanel();
        //}else{
            //Crash::error('403','You don\'t have permission to access this page.');
        //}
});
$forward->route("/crash/admin/pages", function(){
    AdminController::showPagesManager();
});
$forward->route("/crash/admin/pages/edit", function(){
    AdminController::showPageEditor($_GET['id']);
});
?>
