<?php
/**
* This file is first point of reference for all requests.
* From here, we decide how to process incoming requests.
* Generally, it should not be edited. 
*/
//ini_set('display_errors', 'On'); //comment out when in production
session_set_cookie_params(604800);
ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/crash'));
require "/crash/.env";
require "/crash/resources/elements/crash.php";
foreach (Crash\Crash::$element as $e){
    require $e;
}


use Crash\Helper as Helper;
use Crash\Crash as Crash;
use Controller\App\Controller as DefaultController;
use Elements\Session as Session;
use Elements\User as User;

$DB_CONNECTION = Elements\Database::connect();//globally available db connection object

session_start(); //start session only after classes are loaded to avoid incomplete object warning
//this part sets the user object if session exists in the database
$session = Session::getSession(session_id());
if(isset($session)){
    $protagonist = User::getActiveUserById($session->users_id_user);
    if(isset($protagonist)){
        $_SESSION['protagonist']=$protagonist;
    }
}
require "routes.php"; //require routes only after session is loaded because routes need it to verify permissions

$url = trim($_SERVER['REQUEST_URI']);
//strip get vars
$url = explode("?",$url)[0];

try{ //try to forward request to a controller
    //determine request method 
    switch($_SERVER["REQUEST_METHOD"]){
        case "GET":
            $forward->get[$url](); 
        break;
        case "POST":
            $forward->post[$url]();
        break;
    }
}catch(Exception|Throwable){   
    /**
    * this will catch any exception such as route not found or function call failure
    * if function call fails then it means that the route could have a dynamic variable:
    * a route can sometimes have custom parameters that are not within $_GET. in example: /crash/read/some-title 
    * some-title is generated dynamically and cannot be caught by the router 
    * therefore we need to deconstruct the request into controller path and a parameter
    * here $control is a path /crash/read and $dyn_var is some-title
    */
    //check exception type, if its err not warning, then display it
    Crash::error();
    //try to treat the request as if it was a dynamic variable containing request 
    try{
        //strip dynamic uri 
        $url = explode("/",$url);
        $control = "/".$url[1]."/".$url[2];
        $dyn_var = $url[3];
        //do not determine request method because dynamic uris will never be used in post methods
        $forward->get[$control]($dyn_var);//pass dynamic variable to the controller method
    }catch(Exception|Throwable){
        //check exception type, if its err not warning, then display it
        Crash::error();
        //request has completely failed, fallback to the default controller as a last resort
        
        DefaultController::process(Helper::assertRoute()[1]);
    }
    
}


?>
