<?php
namespace Controller\Search;
use Crash\Crash as Crash;
use Crash\Helper as Helper;
use Elements\Publication as Publication;

/*
* This controller processes everything that has to do with searches
*/
class Controller{

    public static function search($query){
        $query = htmlspecialchars(strip_tags(addslashes(strtolower($query))));
        $publications = Publication::getPublication();
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
        include Crash::$static_page['search'];

    }


    public static function search_depreciated($query){
        $query = htmlspecialchars(strip_tags(addslashes(strtolower($query))));
        $publications = Publication::getPublication();

        //we sort publications according to this comparison function passed to usort
        $sorter = function ($q){
           return function($a, $b) use ($q){
                $a_exact = (str_contains(strtolower($a->title), $q)||str_contains(strtolower($a->prompt), $q)||str_contains(strtolower($a->uri), $q));
                $b_exact = (str_contains(strtolower($b->title),$q)||str_contains(strtolower($b->prompt),$q)||str_contains(strtolower($b->uri),$q));
                $a_lev = levenshtein($a->title, $q);
                $b_lev = levenshtein($b->title, $q);
                if(($a_exact && $b_exact)||(!$a_exact && !$b_exact)){
                    return ($a_lev < $b_lev) ? -1 : 1;
                }
                return ($a_exact && !$b_exact) ? -1 : 1;
            };
        };
        usort($publications, $sorter($query));
        include Crash::$static_page['search'];

    }
}

?>
