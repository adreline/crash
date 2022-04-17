<?php
//this class defines a publication db object
require_once "database.php";

class Publication {
  public $id;
  public $title;
  public $planned_length;
  public $status;
  public $time_stamp;
  public $users_id_user;
  public $fandoms_id_fandom;
  
  private static $methods = array(
    'insert' => "INSERT INTO `publications` (`id_publication`, `title`, `planned_length`, `status`, `time_stamp`, `users_id_user`, `fandoms_id_fandom`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP, '%3', '%4')",
    'select' => "SELECT * FROM `publications`",
    'delete' => "DELETE FROM `publications` WHERE id_fandom=%0",
    'update' => "UPDATE `publications` SET `title` = '%0', `planned_length` = '%1', `status` = '%2', `time_stamp` = '%3', `users_id_user` = '%4', `fandoms_id_fandom` = '%5' WHERE `publications`.`id_publication` = %6"
  );
  
  function __construct($id=0,$title,$planned_length,$status,$time_stamp,$users_id_user,$fandoms_id_fandom){
    $this->id = $id;
    $this->title = $title;
    $this->planned_length = $planned_length;
    $this->status = $status;
    $this->time_stamp = $time_stamp;
    $this->users_id_user = $users_id_user;
    $this->fandoms_id_fandom = $fandoms_id_fandom;
  }
  
  public static function getPublication($id=null,$optional_sql=""){
    if(isset($id)){
      $optional_sql="WHERE id_publication=$id ".$optional_sql;
    }
    $sql = Publication::$methods['select']." ".$optional_sql;
    return Database::select($sql, function($row){
        return new Publication($row['id_publication'],$row['title'],$row['planned_length'],$row['status'],$row['time_stamp'],$row['users_id_user'],$row['fandoms_id_fandom']);
    });
  }
  public static function insertPublication($publication){
    $sql = Helper::fill_in(Publication::$methods['insert'],array(
    $publication->title,
    $publication->planned_length,
    $publication->status,$publication->time_stamp,
    $publication->users_id_user,
    $publication->fandoms_id_fandom));
    
    if(Database::insert($sql)){
      echo "Inserted";
    }else{
      echo "Failed to insert";
    }
  }
  public static function deletePublication($id){
    $sql = Helper::fill_in(Publication::$methods['delete'],array($id));
    if(Database::delete($sql)){
      echo "Deleted";
    }else{
      echo "Failed to delete";
    }
  }
  public static function updatePublication($id,$publication){
    $sql = Helper::fill_in(Publication::$methods['update'],array(
    $publication->title,
    $publication->planned_length,
    $publication->status,
    $publication->time_stamp,
    $publication->users_id_user,
    $publication->fandoms_id_fandom,
    $id));
    
    if(Database::update($sql)){
      echo "Inserted";
    }else{
      echo "Failed to insert";
    }
  }
  
}

?>
