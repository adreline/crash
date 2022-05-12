<?php
//this class defines a publication db object
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;
use Elements\Leaflet;

class Publication {
  public $id;
  public $title;
  public $planned_length;
  public $status;
  public $uri;
  public $prompt; 
  public $created_at;
  public $updated_at;
  public $users_id_user;
  public $fandoms_id_fandom;
  public $images_id_image;


  private static $methods = array(
    'insert' => "INSERT INTO `publications` (`id_publication`, `title`, `url`, `planned_length`, `status`, `created_at`, `updated_at`, `fandoms_id_fandom`, `users_id_user`, `prompt`) VALUES (NULL, '%0', '%1', '%2', '%3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '%4', '%5', '%6')",
    'select' => "SELECT * FROM `publications`",
    'delete' => "DELETE FROM `publications` WHERE id_fandom=%0",
    'update' => "UPDATE `publications` SET `title` = '%0', `url`= '%1', `planned_length` = '%2', `status` = '%3',`updated_at` = CURRENT_TIMESTAMP, `users_id_user` = '%4', `fandoms_id_fandom` = '%5' `prompt`='%6' WHERE `publications`.`id_publication` = %7"
  );
  
  function __construct($title=null,$uri=null,$planned_length=0,$status=0,$users_id_user=0,$fandoms_id_fandom=0,$created_at=null,$updated_at=null,$images_id_image=1,$prompt="",$id=0){
    $this->id = $id;
    $this->title = $title;
    $this->uri = $uri;
    $this->planned_length = $planned_length;
    $this->status = $status;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->users_id_user = $users_id_user;
    $this->fandoms_id_fandom = $fandoms_id_fandom;
    $this->images_id_image = $images_id_image;
    $this->prompt = $prompt;
  }
  
  public static function getPublication($id=null,$optional_sql=""){
    if(isset($id)){
      $optional_sql="WHERE id_publication=$id ".$optional_sql;
    }
    $sql = Publication::$methods['select']." ".$optional_sql;
    $res = Database::select($sql, function($row){

        return new Publication(
          $row['title'],
          $row['url'],
          $row['planned_length'],
          $row['status'],
          $row['users_id_user'],
          $row['fandoms_id_fandom'],
          $row['created_at'],
          $row['updated_at'],
          $row['images_id_image'],
          $row['prompt'],
          $row['id_publication']
        );
    });
    return $res;
  }
  public static function getPublicationById($id_pub){
    return Publication::getPublication($id_pub)[0];
  }
  public static function insertPublication($publication){
    if(!isset($publication->title)&&!isset($publication->uri)){
      $publication->uri = uniqid();
    }
    $sql = Helper::fill_in(Publication::$methods['insert'],array(
    $publication->title,
    $publication->uri,
    $publication->planned_length,
    $publication->status,
    $publication->fandoms_id_fandom,
    $publication->users_id_user,
    $publication->prompt
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
    $publication->prompt,
    $publication->id));
    return Database::update($sql);
  }
  public static function getPublicationLeafs($id_publication){//this function is an alias for Leaflet::getLeaflet
    return Leaflet::getLeaflet($id_publication);
  }
  public static function getPublicationByUrl($url){
    return Publication::getPublication(null, "WHERE `publications`.`url` LIKE '$url'")[0];
  }
}

?>
