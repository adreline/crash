<?php

namespace Controller\Reader;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Page as Page;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;

/**
 * This controller manages everything related to reading works such as comments and kudos
 */
class Controller{
    public static function showReader($publication){ 
        if(isset($publication)){
            $leafs = Publication::getPublicationLeafs($publication->id); 
            include Crash::$static_page['athenaeum/reader'];
        }else{
            Crash::error(404,"Publication not found");
        }

    }
}

?>
