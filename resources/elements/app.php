<?php
/**
 * This file holds global variables, that are
 * meant to be a convinient shortcuts
 */
class Crash{
    public static $module=array(
        "navbar"=>"resources/elements/modules/navbar.php",
        "post"=>"resources/elements/modules/post.php",
        "head"=>"resources/elements/modules/head.php"
    );
    public static $element=array(
      "database"=>"resources/elements/database.php",
      "page"=>"resources/elements/page.php",
      "fandom"=>"resources/elements/fandom.php",
      "leaflet"=>"resources/elements/leaflet.php",
      "publication"=>"resources/elements/publication.php"
    );
    public static $static_page=array(
        "home" => "resources/views/home.php"
    );
    public static $template=array(
      "default" => "resources/views/templates/default.php"
    );
}
/**
 * This file holds globaly available functions, that are
 * meant to be a convinient helper functions
 */
class Helper{

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
  public static function assertRoute(){
    $path = ltrim($_SERVER['REQUEST_URI'], '/');    // Trim leading slash(es)
    $uris = explode('/', $path);                // Split path on slashes
    
  }

}

?>
