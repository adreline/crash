<?php
namespace Elements;
//this class defines a user db object
use Elements\Database as Database;
use Crash\Helper as Helper;
use Elements\Publication as Publication;

class User{
  public $id;
  public $username;
  public $password;
  public $kudos;
  public $administrator;
  public $created_at;
  public $updated_at;
  public $image_id;

  function __construct($username,$password,$image_id=1,$administrator=0,$created_at=null,$updated_at=null,$id=0){
    $this->id = $id;
    $this->username = $username;
    $this->password = $password; 
    $this->kudos = 0;
    $this->image_id = $image_id;
    $this->administrator = $administrator;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }

  private static $methods = array(
    'insert'=>"INSERT INTO `users` (id_user,username,password) VALUES (NULL, '%0', '%1')",
    'select'=>"SELECT * FROM `users`",
    'delete'=>"DELETE FROM `users` WHERE id_user=%0",
    'update'=>"UPDATE `users` SET password='%0',username='%1',administrator=%2,kudos=%3,image_id='%4',updated_at=CURRENT_TIMESTAMP WHERE id_user=%5"
  );

  public static function getUser($id=null,$optional_sql=""){
    if(isset($id)){
      $optional_sql="WHERE id_user=$id ".$optional_sql;
    }
    $sql = User::$methods['select']." ".$optional_sql;
    return Database::select($sql, function($row){
      return new User(
      $row['username'],
      $row['password'],
      $row['images_id_image'],
      $row['administrator'],
      $row['created_at'],
      $row['updated_at'],
      $row['id_user']
      );
    });
  }
  
  public static function insertUser($user){
    $sql = Helper::fill_in(User::$methods['insert'],array(
      $user->username,
      $user->password 
    ));
      return Database::insert($sql);
  }
  
  public static function deleteUser($id){
    $sql = Helper::fill_in(User::$methods['delete'],array($id));
    return Database::delete($sql);
  }
  public static function updateUser($user){
    $sql = Helper::fill_in(User::$methods['update'],array(
      $user->password,
      $user->username,
      $user->administrator,
      $user->kudos,
      $user->image_id,
      $user->id
    ));
      return Database::update($sql);
  }
  public static function getUserPublications($id_user){
    return Publication::getPublication(null, "WHERE `users_id_user` = $id_user");
  }
}

?>
