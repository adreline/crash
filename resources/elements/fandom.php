<?php
//this class defines a fandom db object
namespace Elements;
use Crash\Helper;
use Elements\Database;

class Fandom {
  public $id;
  public $friendly_name;
  public $name;
  public $active;
  public $created_at;
  public $updated_at;

  function __construct($friendly_name="",$name=null,$active=0,$id=0,$created_at=null,$updated_at=null){
    $this->id = $id;
    $this->friendly_name = $friendly_name;
    $this->name = (isset($name)) ? $name : str_replace(" ","-",$friendly_name);
    $this->active = $active;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
  }
  
  private static $methods = array(
    'insert' => "INSERT INTO `fandoms` (`id_fandom`, `friendly_name`, `name`, `active`, `created_at`, `updated_at`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)",
    'select' => "SELECT * FROM `fandoms`",
    'delete' => "DELETE FROM `fandoms` WHERE id_fandom=%0",
    'update' => "UPDATE `fandoms` SET `friendly_name` = '%0', `name` = '%1', `active`=%2, `updated_at`=CURRENT_TIMESTAMP WHERE `fandoms`.`id_fandom` = %3"
  );

  private static function getFandom($optional_sql=""){
      $sql = Fandom::$methods['select'].$optional_sql;
      return Database::select($sql, function($row){
            return new Fandom(
              $row['friendly_name'],
              $row['name'],
              $row['active'],
              $row['id_fandom'],
              $row['created_at'],
              $row['updated_at']
            );
      });
  }
  public static function getInactiveFandoms(){
    return Fandom::getFandom("WHERE `fandoms`.`active`= 0");
  }
  public static function getActiveFandoms(){
    return Fandom::getFandom("WHERE `fandoms`.`active`= 1");
  }
  public static function getFandomById($id){
    return Fandom::getFandom("WHERE `fandoms`.`id_fandom`=$id")[0];
  }
  public static function getFandomByName($friendly_name){
    return Fandom::getFandom("WHERE `fandoms`.`friendly_name` LIKE '$friendly_name'")[0];
  }
  public static function insertFandom($fandom){
      $sql = Helper::fill_in(Fandom::$methods['insert'],array($fandom->friendly_name,$fandom->name));
      return Database::insert($sql);
  }
  public static function deleteFandom($id){
    $sql = Helper::fill_in(Fandom::$methods['delete'],array($id));
    return Database::delete($sql);
  }
  public static function updateFandom($fandom){
    $sql = Helper::fill_in(Fandom::$methods['update'],array($fandom->friendly_name,$fandom->name,$fandom->active,$fandom->id));
    return Database::update($sql);
  }
  

}

?>
