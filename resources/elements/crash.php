<?php
namespace Crash;
/**
 * This file holds global variables, that are
 * meant to be a convinient shortcuts
 */
class Crash{
    public static $module=array(
        "navbar"=>"resources/elements/modules/navbar.php",
        "post"=>"resources/elements/modules/post.php",
        "aside"=>"resources/elements/modules/aside.php",
        "modal"=>"resources/elements/modules/modal.php",
        "users_form"=>"resources/elements/modules/users_form.php",
        "user_banner"=>"resources/elements/modules/user_banner.php",
        "head"=>"resources/elements/modules/head.php"
    );
    public static $element=array(
      "database"=>"resources/elements/database.php",
      "page"=>"resources/elements/page.php",
      "fandom"=>"resources/elements/fandom.php",
      "leaflet"=>"resources/elements/leaflet.php",
      "publication"=>"resources/elements/publication.php",
      "session"=>"resources/elements/session.php",
      "head"=>"resources/elements/head.php",
      "user"=>"resources/elements/user.php"
    );
    //This constant, defines static pages that the app recognizes. useful if you need to add a page that can't be created dynamically.
    public static $static_page=array(
        "home" => "resources/views/home.php",
        "about" => "resources/views/about.php",
        "admin/panel" => "resources/views/admin/dashboard.php",
        "admin/pages" => "resources/views/admin/pages/overview.php",
        "admin/pages_editor" => "resources/views/admin/pages/editor.php",
        "user/dashboard" => "resources/views/user/dashboard.php",
        "user/scriptorium" => "resources/views/user/scriptorium/overview.php",
        "user/scriptorium/editor" => "resources/views/user/scriptorium/editor.php",
        "error" => "resources/views/error.php"
    );
    //Primitive templating files with fixed variables to fill. you can add new ones and use them in controllers
    public static $template=array(
      "default" => "resources/views/templates/default.php"
    );
    //When adding new nesting level (higher then 2) you must add a new controller and add it here
    //together with a path to the actuall file. the name used here will be same as in request url.
    public static $controller=array(
      "app" => "resources/elements/controllers/app.php",
      "admin" => "resources/elements/controllers/admin.php",
      "users" => "resources/elements/controllers/users.php"
    );
    
    public static function error($code, $msg){
      include Crash::$static_page['error'];
    }
    public static function notify($title, $body){
      include Crash::$module['modal'];
    }
}
/**
 * This class defines router class and method to attach routes to it.
 * There should only be one router instance per application.
 */
class Router{
  public $get;
  public $post;
  public function route($route, $fn, $method='GET'){
      switch($method){
        case "GET":
          $this->get[$route]=$fn;
        break;
        case "POST":
          $this->post[$route]=$fn;
        break;
      }
      
  }
}
/**
 * This class holds globaly available functions, that are
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
    //this function does some ugly looking url parsing and validating
    $path = trim(str_replace('/',' ',$_SERVER['REQUEST_URI'])); //get rid of trailing slash
    $uris = explode(' ', $path);
    //deconstruct the request
    if ($uris[0]!='crash') {
      //due to htaccess config, it will never not be but just to be sure
        return null;
    }else{
      if (isset($uris[1])&&strlen($uris[1])>0) {
        //this is controller call
        return $uris;
      }else{
        if (sizeof($uris)==1) {
          //this is home call, just return it as home
          $uris[]='home';
          return $uris;
        }
      }
    }
  
    
  }

}

?>
