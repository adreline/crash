<?php
//this class defines a publication db object
namespace Elements;
use Crash\Helper;
use Elements\Database;
use Elements\Leaflet;
use Elements\Image;

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
    'insert' => "INSERT INTO `publications` (`id_publication`, `title`, `url`, `planned_length`, `status`, `created_at`, `updated_at`, `fandoms_id_fandom`, `users_id_user`, `prompt`, `images_id_image`) VALUES (NULL, '%0', '%1', '%2', '%3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '%4', '%5', '%6','%7')",
    'select' => "SELECT * FROM `publications`",
    'delete' => "DELETE FROM `publications` WHERE id_publication=%0",
    'update' => "UPDATE `publications` SET `title` = '%0', `url`= '%1', `planned_length` = '%2', `status` = '%3',`updated_at` = CURRENT_TIMESTAMP, `users_id_user` = '%4', `fandoms_id_fandom` = '%5', `prompt`='%6', `images_id_image`=%7 WHERE `publications`.`id_publication` = %8"
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
  
  private static function getPublications($optional_sql=""){
    $sql = Publication::$methods['select']." ".$optional_sql;
    return Database::select($sql, function($row){
        return new Publication(
          stripslashes($row['title']),
          $row['url'],
          $row['planned_length'],
          $row['status'],
          $row['users_id_user'],
          $row['fandoms_id_fandom'],
          $row['created_at'],
          $row['updated_at'],
          $row['images_id_image'],
          htmlspecialchars_decode(stripslashes($row['prompt']),ENT_QUOTES),
          $row['id_publication']
        );
    });
  }
  public static function getAllPublications($sql){
    return Publication::getPublications($sql);
  }
  public static function getPublicationById($id_pub){
    return Publication::getPublications("WHERE `publications`.`id_publication`=$id_pub")[0];
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
    $publication->prompt,
    $publication->images_id_image
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
    $publication->images_id_image,
    $publication->id));
    return Database::update($sql);
  }
  public static function getPublicationLeafs($id_publication){//this function is an alias for Leaflet::getLeaflet
    return Leaflet::getPublicationLeafs($id_publication);
  }
  public static function getPublicationByUrl($url){
    return Publication::getPublications("WHERE `publications`.`url` LIKE '$url'")[0];
  }
}

?>
