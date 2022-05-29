<?php
namespace Controller\Search;
use Crash\Crash;
use Crash\Helper;
use Elements\Publication;
use Elements\Head;
use Elements\Fandom;
/*
* This controller processes everything that has to do with searches
*/
class Controller{

    public static function fetchFandom($name){
        $fan = Fandom::getFandomByUri($name);
        $publications = Publication::getFandomPublications($fan->id);
        global $head;
        $head->title = "$fan->friendly_name - Crash";
        $head->desc = "See all works in $fan->friendly_name fandom";
        $head->robots = "index,follow";
        $page_title = "Works inside $fan->friendly_name fandom";
        include Crash::$static_page['search'];
    }

    public static function search($query){
        $query = htmlspecialchars(strip_tags(addslashes(strtolower($query))));
        $publications = Publication::getAllPublications();
        //we sort publications according to this comparison function passed to usort
        $sorter = function ($q){
            return function($a, $b) use ($q){
                 similar_text($a->title, $q, $a_sim);
                 similar_text($b->title, $q, $b_sim);
                 if($a_sim == $b_sim) return 0;
                 return ($a_sim > $b_sim) ? -1 : 1;
             };
         };
        usort($publications, $sorter($query));
        global $head;
        $head->title = "Search results - Crash";
        $head->desc = "This is a search result page";
        $head->robots = "noindex,follow";
        $page_title = "Searching for \"$query\"";
        include Crash::$static_page['search'];

    }
}

?>
