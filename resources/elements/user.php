<?php
namespace Elements;
//this class defines a user db object
require_once "database.php";
use Elements\Database as Database;

class User{
  public $id;
  public $username;
  public $password;
  public $kudos;
  public $avatar;
  public $privelage;
  public $created_at;

  function __construct($username,$password,$avatar=null,$privelage=0,$created_at=null,$id=0){
    $this->id = $id;
    $this->username = $username;
    $this->password = $password; 
    $this->kudos = 0;
    $this->avatar = $avatar;
    $this->privelage = $privelage;
    $this->created_at = $created_at;
  }

  private static $methods = array(
    'insert'=>"INSERT INTO `users` (id_user,username,password) VALUES (NULL, '%0', '%1');",
    'select'=>"SELECT * FROM `users`",
    'delete'=>"DELETE FROM `users` WHERE id_user=%0",
    'update'=>"UPDATE `users` SET password='%0',username='%1',administrator=%2,kudos=%3,avatar='%4' WHERE id_user=%5;"
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
      $row['avatar'],
      $row['administrator'],
      $row['time_stamp'],
      $row['id_user']
      );
    });
  }
  
  public static function insertUser($user){
    $sql = Helper::fill_in(User::$methods['insert'],array(
      $user->username,
      $user->password 
    ));
      if(Database::insert($sql)){
        echo "Inserted";
      }else{
        echo "Failed to insert";
      }
  }
  
  public static function deleteUser($id){
    $sql = Helper::fill_in(User::$methods['delete'],array($id));
    if(Database::delete($sql)){
      echo "Deleted";
    }else{
      echo "Failed to delete";
    }
  }
  public static function updateUser($user){
    $sql = Helper::fill_in(User::$methods['update'],array(
      $user->password,
      $user->username,
      $user->privelage,
      $user->kudos,
      $user->avatar,
      $user->id
    ));
      if(Database::update($sql)){
        echo "Updated";
      }else{
        echo "Failed to update";
      }
  }

}

?>
