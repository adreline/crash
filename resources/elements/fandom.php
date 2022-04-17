<?php
//this class defines a fandom db object
require "database.php";

class Fandom {
  public $id;
  public $friendly_name;
  public $name;
  
  function __construct($id=0,$friendly_name){
    $this->id = $id;
    $this->friendly_name = $friendly_name;
    $this->name = str_replace(" ","-",$friendly_name);
  }
  
  private static $methods = array(
    'insert' => "INSERT INTO `fandoms` (`id_fandom`, `friendly_name`, `name`) VALUES (NULL, '%0', '%1')",
    'select' => "SELECT * FROM `fandoms`",
    'delete' => "DELETE FROM `fandoms` WHERE id_fandom=%0",
    'update' => "UPDATE `fandoms` SET `friendly_name` = '%0', `name` = '%1' WHERE `fandoms`.`id_fandom` = %2"
  );
  
  public static function getFandom($id=null,$optional_sql=""){
      if(isset($id)){
       $optional_sql="WHERE id_fandom=$id ".$optional_sql;
      }
      $sql = Fandom::$methods['select'].$optional_sql
      return Database::select($sql, function($row){
            return new Fandom($row['id_fandom'],$row['friendly_name'],$row['name']);
      });
  }
  
  public static function insertFandom($fandom){
      $sql = Helper::fill_in(Fandom::$methods['insert'],array($fandom->friendly_name,$fandom->name));
      if(Database::insert($sql)){
        echo "Inserted";
      }else{
        echo "Failed to insert";
      }
  }
  public static function deleteFandom($id){
    $sql = Helper::fill_in(Fandom::$methods['delete'],array($id));
    if(Database::delete($sql)){
      echo "Deleted";
    }else{
      echo "Failed to delete";
    }
  }
  public static function updateFandom($id,$fandom){
    $sql = Helper::fill_in(Fandom::$methods['update'],array($fandom->friendly_name,$fandom->name,$id));
    if(Database::update($sql)){
        echo "Updated";
      }else{
        echo "Failed to update";
      }
  }
  

}

?>
