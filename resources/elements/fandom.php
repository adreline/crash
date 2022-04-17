<?php
//this class defines a fandom db object
class Fandom {
  public $id;
  public $friendly_name;
  public $name;
  public static $methods = array(
    'insert' => "INSERT INTO `fandoms` (`id_fandom`, `friendly_name`, `name`) VALUES (NULL, '%0', '%1')",
    'select' => "SELECT * FROM `fandoms`"
  );
  
  function __construct($id,$friendly_name,$name){
    $this->id = $id;
    $this->friendly_name = $friendly_name;
    $this->name = $name;
  }
}

?>
