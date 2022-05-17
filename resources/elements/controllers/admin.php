<?php

namespace Controller\Admin;
use Crash\Crash as Crash;
use Elements\User as User;
use Elements\Page as Page;
use Elements\Head as Head;
use Elements\Fandom as Fandom;

/**
 * This controller provides access to the admin interface
 */
class Controller{
  /* fandom requests methods */
  public static function showFandomRequests(){
    include Crash::$static_page['admin/fandom/requests'];
  }
  public static function acceptFandomRequest($id_fandom){
    $fandom = Fandom::getFandomById($id_fandom);
    $fandom->active = 1;
    if(!Fandom::updateFandom($fandom)) die(mysql_error);
    Crash::redirect("/crash/admin/fandoms");
  }
  public static function denyFandomRequest($id_fandom){
    if(!Fandom::deleteFandom($id_fandom)) die(mysql_error);
    Crash::redirect("/crash/admin/fandoms");
  }


  public static function showPanel(){
      include Crash::$static_page['admin/panel'];
  }
  /* pages methods */
  public static function showPagesManager(){
      $pages = Page::getPage();
      include Crash::$static_page['admin/pages'];
  }
  public static function showPageEditor($id_page=null){
      if(isset($id_page) && is_numeric($id_page)){
            $page = Page::getPageById($id_page);
            $head = Page::getHead($id_page);
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
      }else{
        $page = Page::getPageByName($form['name']);
        $head = new Head(
          $form['meta_title'],
          $form['meta_desc'],
          $page->id 
        );
        if(!Head::insertHead($head)){
          die(mysql_error);
        }
      }
      Crash::redirect("/crash/admin/pages");
  }
  public static function updatePage($form){
      $page = new Page(
      $form['name'],
      $form['friendly_name'],
      htmlspecialchars($form['content'],ENT_QUOTES),
      htmlspecialchars($form['custom_css'],ENT_QUOTES),
      htmlspecialchars($form['javascript'],ENT_QUOTES),
      $form['id_page']);
      $head = new Head(
        $form['meta_title'],
        $form['meta_desc'],
        $form['id_page'],
        Head::getHead($form['id_page'])->id
      );
      if(!Page::editPage($page)||!Head::updateHead($head)){
       die(mysql_error);
      }
      Crash::redirect("/crash/admin/pages");
  }
  public static function deletePage($id_page){
    //key constraint will fail if we attempt to delete a page, first delete associated head section
    $head = Head::getHead($id_page);
    if(!Head::deleteHead($head->id)){
      die(mysql_error);
    }
    if(!Page::deletePage($id_page)){
      die(mysql_error);
    }
    Crash::redirect("/crash/admin/pages");
  }
}

?>
