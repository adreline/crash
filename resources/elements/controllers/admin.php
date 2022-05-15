<?php

namespace Controller\Admin;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Page as Page;
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
      if(isset($id_page) && is_numeric($id_page)){
            $page = Page::getPageById($id_page);
            $action = "/crash/admin/pages/edit";
      }else{
            $page = new Page(); //pass an empty page object because we want to make a new one while recycling the same form
            $head = new Head();
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
      Crash::redirect("/crash/admin/pages",["title"=>"success","message"=>"Page created"]);
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
      Crash::redirect("/crash/admin/pages",["title"=>"success","message"=>"Page updated"]);
  }
  public static function deletePage($id_page){
    if(!Page::deletePage($id_page)){
      die(mysql_error);
    }
    Crash::redirect("/crash/admin/pages",["title"=>"success","message"=>"Page deleted"]);
  }
}

?>
