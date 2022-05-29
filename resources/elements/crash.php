<?php
namespace Crash;
/**
 * This file holds global variables, that are
 * meant to be a convinient shortcuts
 */
class Crash{
    public static $module=array(
        "navbar"=>"resources/views/templates/modules/navbar.php",
        "aside"=>"resources/views/templates/modules/aside.php",
        "modal"=>"resources/views/templates/modules/modal.php",
        "users_form"=>"resources/views/templates/modules/users_form.php",
        "user_banner"=>"resources/views/templates/modules/user_banner.php",
        "user_banner_mobile"=>"resources/views/templates/modules/user_banner_mobile.php",
        "users_form_mobile"=>"resources/views/templates/modules/users_form_mobile.php",
        "head"=>"resources/views/templates/modules/head.php"
    );
    public static $element=array(
      "database"=>"resources/elements/database.php",
      "session"=>"resources/elements/session.php",
      "image"=>"resources/elements/image.php",
      "validator"=>"resources/elements/validator.php",
      "user"=>"resources/elements/user.php"
    );
    //This constant, defines static pages that the app recognizes. useful if you need to add a page that can't be created dynamically.
    public static $static_page=array(
        "home" => "resources/views/home.php",
        "admin/panel" => "resources/views/admin/dashboard.php",
        "admin/users/dashboard" => "resources/views/admin/users/dashboard.php",
        "user/dashboard" => "resources/views/user/dashboard.php",
        "user/password" => "resources/views/user/profile/password.php",
        "user/delete" => "resources/views/user/profile/delete.php",
        "user/avatar" => "resources/views/user/profile/avatar.php",
        "user/username" => "resources/views/user/profile/username.php",
        "loading" => "resources/views/loading.php"
    );
    //Primitive templating files with fixed variables to fill. you can add new ones and use them in controllers
    public static $template=array(
    );
    //When adding new nesting level (higher then 2) you must add a new controller and add it here
    //together with a path to the actuall file. the name used here will be same as in request url.
    public static $controller=array(
      "app" => "resources/elements/controllers/app.php",
      "admin" => "resources/elements/controllers/admin.php",
      "users" => "resources/elements/controllers/users.php",
    );
    
    public static function error($code=null, $msg=null){
      if(!isset($code)){
        $e=error_get_last();
        if(!isset($e)) return null;
        if(Helper::str_contains($e['message'],"Undefined array key")) return null;
        $msg=$e['message']."<br>".$e['file']."<br>".$e['line'];
        $code=500;
        include Crash::$static_page['error'];
        die();
      }else{
        include Crash::$static_page['error'];
        die();
      } 
    }
    public static function notify($title, $body){
      include Crash::$module['modal'];
    }
    public static function redirect($target,$message=null){
      include Crash::$static_page['loading'];
      if(isset($message)){
        $serial = $message['title'].";".$message['message'];
        setcookie("notification",$serial,time()+10,$target);
      }
      echo "<meta http-equiv=\"refresh\" content=\"0;url=$target\">";
      die();
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
    if ($uris[0]!='crash') return null; //due to htaccess config, it will never not be but just to be sure
    if (isset($uris[1])&&strlen($uris[1])>0) return $uris; //this is controller call
    if (sizeof($uris)==1) {
      //this is home call, just return it as home
      $uris[]='home';
      return $uris;
    }
  }
}

?>
