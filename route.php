<?php 
require "resources/elements/app.php";
require Crash::$element['page'];

if(isset($uris[1])&&strlen($uris[1])!=0){
    $route = $uris[1];
    $page_id = Page::fetchPageByName($route);
    if($page_id!=-1){
        $page = Page::getPage($page_id);
        include Crash::$template['default'];
    }else{
        header('HTTP/1.1 404 Not Found');
    }
}else{
    include Crash::$static_page['home'];
}

?>