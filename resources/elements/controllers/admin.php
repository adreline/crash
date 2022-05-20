<?php
namespace Controller\Admin;
use Crash\Crash as Crash;
use Elements as E;

/**
 * This controller provides access to the admin interface
 */
class Controller{
  /* user management methods */
  public static function showUsers(){
    include Crash::$static_page['admin/users/dashboard'];
  }
  public static function disableUser($id_user){
    if(!E\User::deleteUser($id_user)) die(mysql_error);
    foreach(E\Session::getSessionsByUserId($id_user) as $sess){
      E\Session::deleteSession($sess->id);
    }
    Crash::redirect("/crash/admin/users");
  }
  public static function enableUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->active = 1;
    $user->username = str_replace(" (account deleted)","",$user->username);
    if(!E\User::updateUser($user)) die(mysql_error);
    Crash::redirect("/crash/admin/users");
  }
  public static function demoteUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->administrator = 0;
    if(!E\User::updateUser($user)) die(mysql_error);
    Crash::redirect("/crash/admin/users");
  }
  public static function elevateUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->administrator = 1;
    if(!E\User::updateUser($user)) die(mysql_error);
    Crash::redirect("/crash/admin/users");
  }
  /* fandom requests methods */
  public static function showFandomRequests(){
    include Crash::$static_page['admin/fandom/requests'];
  }
  public static function acceptFandomRequest($id_fandom){
    $fandom = E\Fandom::getFandomById($id_fandom);
    $fandom->active = 1;
    if(!E\Fandom::updateFandom($fandom)) die(mysql_error);
    Crash::redirect("/crash/admin/fandoms");
  }
  public static function denyFandomRequest($id_fandom){
    if(!E\Fandom::deleteFandom($id_fandom)) die(mysql_error);
    Crash::redirect("/crash/admin/fandoms");
  }


  public static function showPanel(){
      include Crash::$static_page['admin/panel'];
  }
  /* pages methods */
  public static function showPagesManager(){
      $pages = E\Page::getAllPages();
      include Crash::$static_page['admin/pages'];
  }
  public static function showPageEditor($id_page=null){
      if(isset($id_page) && is_numeric($id_page)){
            $page = E\Page::getPageById($id_page);
            $head = E\Page::getHead($id_page);
            $action = "/crash/admin/pages/edit";
      }else{
            $page = new E\Page(); //pass an empty page object because we want to make a new one while recycling the same form
            $head = new E\Head();
            $action = "/crash/admin/pages/new";
      }
      include Crash::$static_page['admin/pages_editor'];
  }
  public static function insertNewPage($form){
      if($form['name']=="")$form['name']=str_replace(" ","-",$form['friendly_name']);
      $page = new E\Page(
      $form['name'],
      $form['friendly_name'],
      htmlspecialchars($form['content'],ENT_QUOTES),
      htmlspecialchars($form['custom_css'],ENT_QUOTES),
      htmlspecialchars($form['javascript'],ENT_QUOTES)
      );
      
      if(!E\Page::insertPage($page)) die(mysql_error);
      $page = E\Page::getPageByName($form['name']);
      $head = new E\Head(
        $form['meta_title'],
        $form['meta_desc'],
        $page->id 
      );
      if(!E\Head::insertHead($head)) die(mysql_error);
      Crash::redirect("/crash/admin/pages");
  }
  public static function updatePage($form){
      $page = new E\Page(
      $form['name'],
      $form['friendly_name'],
      htmlspecialchars($form['content'],ENT_QUOTES),
      htmlspecialchars($form['custom_css'],ENT_QUOTES),
      htmlspecialchars($form['javascript'],ENT_QUOTES),
      $form['id_page']);
      $head = new E\Head(
        $form['meta_title'],
        $form['meta_desc'],
        $form['id_page'],
        E\Head::getHead($form['id_page'])->id
      );
      if(!E\Page::editPage($page)||!E\Head::updateHead($head)) die(mysql_error);
      Crash::redirect("/crash/admin/pages");
  }
  public static function deletePage($id_page){
    //key constraint will fail if we attempt to delete a page, first delete associated head section
    $head = E\Head::getHead($id_page);
    if(!E\Head::deleteHead($head->id) || !E\Page::deletePage($id_page)) die(mysql_error);
    Crash::redirect("/crash/admin/pages");
  }
}

?>
