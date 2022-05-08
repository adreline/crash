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
  public static function showPageEditor($id_page){
      $page = Page::getPage($id_page);
      include Crash::$static_page['admin/pages_editor'];
  }
}

?>
