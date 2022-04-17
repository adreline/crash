<?php
/**
 * This file holds global variables, that are
 * meant to be a convinient shortcuts
 */
class Helper{

public static $locations=array(
        "elements"=>"resources/elements/"
    );
public static $modules=array(
        "navbar"=>"resources/elements/modules/navbar.php",
        "head"=>"resources/elements/modules/head.php",
        "database"=>"resources/elements/database.php",
        "fandom"=>"resources/elements/fandom.php",
        "publication"=>"resources/elements/publication.php"
    );
    public static function str_contains(string $haystack, string $needle): bool{
      return '' === $needle || false !== strpos($haystack, $needle);
    }
//helper functions 
    public static function fill_in($str,$data){
      //this funct inserts data into strings at specified places
      $head="%0";
      $pos=0;
      while (Helper::str_contains($str,$head)) {
        $str=str_replace($head,$data[$pos],$str);
        $pos++;
        $head="%$pos";
      }
      return $str;
    }

}


?>
