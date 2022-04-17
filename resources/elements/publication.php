<?php
//this class defines a fandom db object
class Publication {
  public $id;
  public $title;
  public $planned_length;
  public $status;
  public $time_stamp;
  public $users_id_user;
  public $fandoms_id_fandom;
  
  public static $methods = array(
    'insert' => "INSERT INTO `publications` (`id_publication`, `title`, `planned_length`, `status`, `time_stamp`, `users_id_user`, `fandoms_id_fandom`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP, '%3', '%4')",
    'select' => "SELECT * FROM `publications`"
  );
  
  function __construct($id,$title,$planned_length,$status,$time_stamp,$users_id_user,$fandoms_id_fandom){
    $this->id = $id;
    $this->title = $title;
    $this->planned_length = $planned_length;
    $this->status = $status;
    $this->time_stamp = $time_stamp;
    $this->users_id_user = $users_id_user;
    $this->fandoms_id_fandom = $fandoms_id_fandom;
  }
}

?>
