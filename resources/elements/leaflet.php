<?php
//this class defines a fanfic page object
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;

class Leaflet{
  public $id;
  public $body;
  public $publications_id_publication;
  
  function __construct($id=0,$body,$publications_id_publication){
    $this->id = $id;
    $this->body = $body;
    $this->publications_id_publication = $publications_id_publication;
  }
  
  private static $methods = array(
    'insert' => "INSERT INTO `leafs` (`id_leaf`, `body`, `publications_id_publication`) VALUES (NULL, '%0', '%1')",
    'select' => "SELECT * FROM `leafs` WHERE `leafs`.`publications_id_publication` = %0",
    'delete' => "DELETE FROM `leafs` WHERE `leafs`.`id_leaf` = %0",
    'update' => "UPDATE `leafs` SET `body` = '%0' WHERE `leafs`.`id_leaf` = %1"
  );

  public static function getLeaflet($id_publication){
    //it doesnt make sense to pull a leaf by its id on its own. pull all leafs, belonging to given publication.
    $sql = Helper::fill_in(Leaflet::$methods['select'],array($id_publication));
    return Database::select($sql, function($row){
      return new Leaflet($row['id_leaf'],$row['body'],$row['publications_id_publication']);
    });
  }
  public static function insertLeaflet($leaf){
    $sql = Helper::fill_in(Leaflet::$methods['insert'],array($leaf->body,$leaf->publications_id_publication));
      if(Database::insert($sql)){
        echo "Inserted";
      }else{
        echo "Failed to insert";
      }
  }
  public static function deleteLeaflet($id){
    $sql = Helper::fill_in(Leaflet::$methods['delete'],array($id));
    if(Database::delete($sql)){
        echo "Deleted";
      }else{
        echo "Failed to delete";
      }
  }
  public static function updateLeaflet($id,$leaf){
    $sql = Helper::fill_in(Leaflet::$methods['update'],array($leaf->body,$id));
    if(Database::update($sql)){
        echo "Updated";
      }else{
        echo "Failed to update";
      }
  }
}
