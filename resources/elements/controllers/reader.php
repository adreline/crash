<?php

namespace Controller\Reader;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Publication as Publication;
use Elements\Leaflet as Leaflet;
use Elements\Kudo;
use Elements\Comment as Comment;

/**
 * This controller manages everything related to reading works such as comments and kudos
 */
class Controller{
    public static function showReader($publication){ 
        if(isset($publication)){
            $leafs = Publication::getPublicationLeafs($publication->id); 
            $kudo_count = Kudo::countPublicationKudosById($publication->id);
            $pub_author =  User::getUserById($publication->users_id_user)->username;
            $pub_status = ($publication->status) ? "finished" : "ongoing";
            $comments = Comment::getPublicationComments($publication->id);
            include Crash::$static_page['athenaeum/reader'];
        }else{
            Crash::error(404,"Publication not found");
        }

    }
}

?>
