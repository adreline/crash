<?php
/**
* This file is first point of reference for all requests.
* From here, we decide how to process incoming requests.
* Generally, it should not be edited. 
*/
ini_set('display_errors', 'On'); //comment out when in production
session_set_cookie_params(604800);
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/crash'));
session_start();
require "/crash/.env";
require "/crash/resources/elements/crash.php";
require "routes.php";
foreach (Crash\Crash::$element as $e){
    require $e;
}

use Crash\Helper as Helper;
use function Controller\App\process as app_process;
use Elements\Session as Session;
//this part sets the user object if session exists in the database
$protagonist = Session::getSession(session_id());

if(isset($protagonist)){
    $_SESSION['protagonist']=$protagonist;
}

try{
    //try to forward request to a controller
    $req = trim($_SERVER['REQUEST_URI']);
    $forward->lookup[$req]();
}catch(Exception|Throwable){   
    //if route not found in the lookup tabe, fall back to the default controller as a last resort
    app_process(Helper::assertRoute()[1]);
}


?>