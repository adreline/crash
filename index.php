<?php
/**
* This file is first point of reference for all requests.
* From here, we decide how to process incoming requests.
* Generally, it should not be edited. 
*/
ini_set('display_errors', 'On'); //comment out when in production
require "/crash/.env";
require "/crash/resources/elements/crash.php";
require "routes.php";
foreach (Crash\Crash::$element as $e){
    require $e;
}

use Crash\Helper as Helper;
use function Controller\App\process as app_process;


try{
    //try to forward request to a controller
    $req = $_SERVER['REQUEST_URI'];
    $forward->lookup[$req]();
}catch(Exception|Throwable){
    //if route not found in the lookup tabe, fall back to the default controller as a last resort
    app_process(Helper::assertRoute()[1]);
}


?>