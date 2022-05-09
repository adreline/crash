<?php
/**
* This file is first point of reference for all requests.
* From here, we decide how to process incoming requests.
* Generally, it should not be edited. 
*/
ini_set('display_errors', 'On'); //comment out when in production
session_set_cookie_params(604800);
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/crash'));

require "/crash/.env";
require "/crash/resources/elements/crash.php";
foreach (Crash\Crash::$element as $e){
    require $e;
}


use Crash\Helper as Helper;
use function Controller\App\process as app_process;
use Elements\Session as Session;
use Elements\User as User;
session_start(); //start session only after classes are loaded to avoid incomplete object warning
//this part sets the user object if session exists in the database
$session = Session::getSession(session_id());
if(isset($session)){
    $protagonist = User::getUser($session->users_id_user);
    if(isset($protagonist[0])){
        $_SESSION['protagonist']=$protagonist[0];
    }
}
require "routes.php"; //require routes only after session is loaded because routes need it to verify permissions

try{
    //try to forward request to a controller
    $req = trim($_SERVER['REQUEST_URI']);
    //strip get vars
    $req = explode("?",$req)[0];
    //determine request method 
    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            $forward->get[$req]();
        break;
        case "POST":
            $forward->post[$req]();
        break;
    }
    
}catch(Exception|Throwable){   
    //if route not found in the lookup tabe, fall back to the default controller as a last resort
    app_process(Helper::assertRoute()[1]);
}


?>
