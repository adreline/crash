<?php
//this class defines a fanfic page object
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;

class Leaflet{
  public $id;
  public $title;
  public $body;
  public $word_count;
  public $publications_id_publication;
  public $created_at;
  public $updated_at;
  
  function __construct($title="",$body="",$word_count=0,$publications_id_publication=1,$created_at=null,$updated_at=null,$id=0){
    $this->id = $id;
    $this->title = $title;
    $this->body = $body;
    $this->word_count = $word_count;
    $this->publications_id_publication = $publications_id_publication;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
  
  private static $methods = array(
    'insert' => "INSERT INTO `leafs` (`id_leaf`,`title`, `body`,`word_count`, `publications_id_publication`,`created_at`,`updated_at`) VALUES (NULL,'%0','%1', %2, %3,  CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)",
    'select' => "SELECT * FROM `leafs` WHERE `leafs`.`publications_id_publication` = %0",
    'select_by_id' => "SELECT * FROM `leafs` WHERE `leafs`.`id_leaf` = %0",
    'delete' => "DELETE FROM `leafs` WHERE `leafs`.`id_leaf` = %0",
    'update' => "UPDATE `leafs` SET `body` = '%0', `title` = '%1', `word_count`=%2, `updated_at`=CURRENT_TIMESTAMP WHERE `leafs`.`id_leaf` = %3"
  );

  public static function getLeaflet($id,$method='select'){
    $sql = Helper::fill_in(Leaflet::$methods[$method],array($id));
    return Database::select($sql, function($row){
      return new Leaflet(
        stripslashes($row["title"]),
        htmlspecialchars_decode(stripslashes($row['body']),ENT_QUOTES),
        $row['word_count'],
        $row['publications_id_publication'],
        $row['created_at'],
        $row['updated_at'],
        $row['id_leaf']);
    });
  }
  public static function getLeafletById($id){
    return Leaflet::getLeaflet($id,'select_by_id')[0];
  }
  public static function insertLeaflet($leaf){
    $sql = Helper::fill_in(Leaflet::$methods['insert'],array($leaf->title,$leaf->body,$leaf->word_count,$leaf->publications_id_publication));
    return Database::insert($sql);
  }
  public static function deleteLeaflet($id){
    $sql = Helper::fill_in(Leaflet::$methods['delete'],array($id));
    return Database::delete($sql);
  }
  public static function updateLeaflet($leaf){
    $sql = Helper::fill_in(Leaflet::$methods['update'],array($leaf->body,$leaf->title,$leaf->word_count,$leaf->id));
    return Database::update($sql);
  }
}
