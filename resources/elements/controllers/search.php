<?php
namespace Controller\Search;
use Crash\Crash;
use Crash\Helper;
use Elements\Publication;
use Elements\Head;
/*
* This controller processes everything that has to do with searches
*/
class Controller{

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
        include Crash::$static_page['search'];

    }
}

?>
