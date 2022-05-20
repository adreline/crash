<?php

namespace Controller\Reader;
use Crash\Crash as Crash;
use Elements as E;
/**
 * This controller manages everything related to reading works such as comments and kudos
 */
class Controller{
    public static function showReader($publication){ 
        if(isset($publication)){
            $leafs = E\Publication::getPublicationLeafs($publication->id); 
            $kudo_count = E\Kudo::countPublicationKudosById($publication->id);
            $pub_author =  E\User::getUserById($publication->users_id_user)->username;
            $pub_status = ($publication->status) ? "finished" : "ongoing";
            $comments = E\Comment::getPublicationComments($publication->id);
            $cover = E\Image::getImageById($publication->images_id_image);
            $tags = E\Tag::getPublicationTags($publication->id);
            global $head;
            $head->title = "$publication->title - work by $pub_author - Crash";
            $head->desc = $publication->prompt;
            $head->robots = "index,follow";
            include Crash::$static_page['athenaeum/reader'];
        }else{
            Crash::error(404,"Publication not found");
        }

    }
}

?>
