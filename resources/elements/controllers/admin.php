<?php

namespace Controller\Admin;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Page as Page;
use function Controller\App\process as redirect_home;
/**
 * This controller provides access to the admin interface
 */
class Controller{
  public static function showPanel(){
      include Crash::$static_page['admin/panel'];
  }
  public static function showPagesManager(){
      $pages = Page::getPage();
      include Crash::$static_page['admin/pages'];
  }
  public static function showPageEditor($id_page=null){
      if(isset($id_page)){
            $page = Page::getPage($id_page)[0];
            $action = "/crash/admin/pages/edit";
      }else{
            $page = new Page("","",""); //pass an empty page object because we want to make a new one while recycling the same form
            $action = "/crash/admin/pages/new";
      }
      include Crash::$static_page['admin/pages_editor'];
  }
  public static function insertNewPage($form){
      if($form['name']==""){
            $form['name']=str_replace(" ","-",$form['friendly_name']);
      }
      $page = new Page(
      $form['name'],
      $form['friendly_name'],
      htmlspecialchars($form['content'],ENT_QUOTES),
      htmlspecialchars($form['custom_css'],ENT_QUOTES),
      htmlspecialchars($form['javascript'],ENT_QUOTES)
      );
      
      if(!Page::insertPage($page)){
        die(mysql_error);
      }
     redirect_home('home',function(){
        Crash::notify("success","Page created");
      });
  }
  public static function updatePage($form){
      $page = new Page(
      $form['name'],
      $form['friendly_name'],
      htmlspecialchars($form['content'],ENT_QUOTES),
      htmlspecialchars($form['custom_css'],ENT_QUOTES),
      htmlspecialchars($form['javascript'],ENT_QUOTES),
      $form['id_page']);
      
      if(!Page::editPage($page)){
       die(mysql_error);
      }
      redirect_home('home',function(){
        Crash::notify("success","Page updated");
      });
  }
  public static function deletePage($id_page){
    if(!Page::deletePage($id_page)){
      die(mysql_error);
    }
    redirect_home('home',function(){
      Crash::notify("success","Page deleted");
    });
  }
}

?>