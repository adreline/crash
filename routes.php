<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
require Crash::$controller['app'];
require Crash::$controller['users'];
use function Controller\App\process as app_process;
use function Controller\Users\enlist as users_enlist;
use function Controller\Users\logout as users_logout;
use function Controller\Users\view_profile as view_profile;

$forward = new Router();

$forward->route("/crash/", function(){
    app_process("home");
});
$forward->route("/crash/users/enlist", function(){
    users_enlist();
});
$forward->route("/crash/users/logout", function(){
    users_logout();
});
$forward->route("/crash/users/profile", function(){
    view_profile();
});
?>
