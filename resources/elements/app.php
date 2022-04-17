<?php
/**
 * This file holds global variables, that are
 * meant to be a convinient shortcuts
 */

$locations=array(
        "elements"=>"resources/elements/"
    );
$modules=array(
        "navbar"=>$locations['elements']."modules/navbar.php",
        "head"=>$locations['elements']."modules/head.php",
        "database"=>$locations['elements']."database.php"
    );
//helper functions 
    function fill_in($str,$data){
      //this funct inserts data into strings at specified places
      $head="%0";
      $pos=0;
      while (str_contains($str,$head)) {
        $str=str_replace($head,$data[$pos],$str);
        $pos++;
        $head="%$pos";
      }
      return $str;
    }

?>
