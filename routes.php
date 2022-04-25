<?php
use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Crash\Router as Router;
require Crash::$controller['app'];
require Crash::$controller['users'];
use function Controller\App\process as app_process;
use function Controller\Users as users_process;

$forward = new Router();

$forward->route("/crash/", function(){
    app_process("home");
});
$forward->route("/crash/users/enlist", function(){
    users_process();
});

?>