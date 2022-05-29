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
    global $head;
    $head->title = "manage users - admin dashboard - Crash";
    $head->desc = "user management page";
    $head->robots = "noindex,follow";
    include Crash::$static_page['admin/users/dashboard'];
  }
  public static function disableUser($id_user){
    if(!E\User::deleteUser($id_user)) Crash::error(500,"internal server error");
    foreach(E\Session::getSessionsByUserId($id_user) as $sess){
      E\Session::deleteSession($sess->id);
    }
    Crash::redirect("/crash/admin/users");
  }
  public static function enableUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->active = 1;
    $user->username = str_replace(" (account deleted)","",$user->username);
    if(!E\User::updateUser($user)) Crash::error(500,"internal server error");
    Crash::redirect("/crash/admin/users");
  }
  public static function demoteUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->administrator = 0;
    if(!E\User::updateUser($user)) Crash::error(500,"internal server error");
    Crash::redirect("/crash/admin/users");
  }
  public static function elevateUser($id_user){
    $user = E\User::getUserById($id_user);
    $user->administrator = 1;
    if(!E\User::updateUser($user)) Crash::error(500,"internal server error");
    Crash::redirect("/crash/admin/users");
  }

}

?>
