<?php
//this class defines a publication db object
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;
use Elements\Leaflet;

class Publication {
  public $id;
  public $title;
  public $uri;
  public $planned_length;
  public $status;
  public $created_at;
  public $updated_at;
  public $users_id_user;
  public $fandoms_id_fandom;


  private static $methods = array(
    'insert' => "INSERT INTO `publications` (`id_publication`, `title`, `uri`, `planned_length`, `status`, `created_at`, `updated_at`, `fandoms_id_fandom`, `users_id_user`) VALUES (NULL, '%0', '%1', '%2', '%3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '%4', '%5')",
    'select' => "SELECT * FROM `publications`",
    'delete' => "DELETE FROM `publications` WHERE id_fandom=%0",
    'update' => "UPDATE `publications` SET `title` = '%0', `uri`= '%1', `planned_length` = '%2', `status` = '%3',`updated_at` = CURRENT_TIMESTAMP, `users_id_user` = '%4', `fandoms_id_fandom` = '%5' WHERE `publications`.`id_publication` = %6"
  );
  
  function __construct($title="",$uri="",$planned_length=0,$status=0,$users_id_user=0,$fandoms_id_fandom=0,$created_at=0,$updated_at=0,$id=0){
    $this->id = $id;
    $this->title = $title;
    $this->uri = $uri;
    $this->planned_length = $planned_length;
    $this->status = $status;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->users_id_user = $users_id_user;
    $this->fandoms_id_fandom = $fandoms_id_fandom;
  }
  
  public static function getPublication($id=null,$optional_sql=""){
    if(isset($id)){
      $optional_sql="WHERE id_publication=$id ".$optional_sql;
    }
    $sql = Publication::$methods['select']." ".$optional_sql;
    return Database::select($sql, function($row){
        return new Publication(
          $row['title'],
          $row['uri'],
          $row['planned_length'],
          $row['status'],
          $row['users_id_user'],
          $row['fandoms_id_fandom'],
          $row['created_at'],
          $row['updated_at'],
          $row['id_publication']
        );
    });
  }
  public static function insertPublication($publication){
    $sql = Helper::fill_in(Publication::$methods['insert'],array(
    $publication->title,
    $publication->uri,
    $publication->planned_length,
    $publication->status,
    $publication->fandoms_id_fandom,
    $publication->users_id_user
    ));
    return Database::insert($sql);
  }
  public static function deletePublication($id){
    $sql = Helper::fill_in(Publication::$methods['delete'],array($id));
    return Database::delete($sql);
  }
  public static function updatePublication($publication){
    $sql = Helper::fill_in(Publication::$methods['update'],array(
    $publication->title,
    $publication->uri,
    $publication->planned_length,
    $publication->status,
    $publication->users_id_user,
    $publication->fandoms_id_fandom,
    $publication->id));
    return Database::update($sql);
  }
  public static function getPublicationLeafs($id_publication){//this function is an alias for Leaflet::getLeaflet
    return Leaflet::getLeaflet($id_publication);
  }
}

?>
