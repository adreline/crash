<?php 
require "resources/elements/crash.php";
require Crash::$element['page'];
/**
* This file is first point of reference for all requests.
* From here, we decide how to process incoming requests.
* Generally, it should not be edited. 
*/
$req = Helper::assertRoute();
if (isset($req)) {
    //decide which controller to use 
    if (sizeof($req)>2) {
        //if more then 2, it means we need to pass this request to specified controller
        //look for a controller
        if (isset(Crash::$controller[$req[1]])) {
            //controller exists, pass request to it
            require Crash::$controller[$req[1]];
            process($req[2]);
        }else{
            //controller was not found return 404
            include Crash::$static_page['404'];
        }
    }else{
        //if the request only have 2 fields, that means it will use default controller
        require Crash::$controller['app'];
        process($req[1]);
    }
}else{
     include Crash::$static_page['404'];
}

?>
