<?php
//this class defines a section head for any page object
namespace Elements;
use Crash\Helper;
use Elements\Database;

class Head{
  public $id;
  public $title; //meta title
  public $desc; //meta description
  public $robots; //defaults to index,follow
  public $pages_id_page;
  public $created_at; 
  public $updated_at;

  function __construct($title="", $desc="",$robots=null, $pages_id=0,$id=0,$created_at=null,$updated_at=null){
    $this->title = $title;
    $this->desc = $desc;
    $this->robots = $robots;
    $this->pages_id_page = $pages_id;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
    $this->id = $id;
  }

  public static $methods = array(
      'insert' => "INSERT INTO `heads` (`id_head`, `title`, `desc`,`robots`, `pages_id_page`,`created_at`,`updated_at`) VALUES (NULL, '%0', '%1','%2', '%3',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)",
      'select' => "SELECT * FROM `heads` WHERE `pages_id_page` = %0",
      'delete' => "DELETE FROM `heads` WHERE `heads`.`id_head` = %0",
      'update' => "UPDATE `heads` SET `title` = '%0', `desc` = '%1', `pages_id_page` = '%2',`robots`='%3', `updated_at`=CURRENT_TIMESTAMP WHERE `heads`.`id_head` = %4",
  );

  public static function getHead($id_page){
      $sql = Helper::fill_in(Head::$methods['select'],array($id_page));
      return Database::select($sql, function ($row){
          return new Head(
              $row['title'],
              $row['desc'],
              $row['robots'],
              $row['pages_id_page'],
              $row['id_head'],
              $row['created_at'], 
              $row['updated_at']
          );
      })[0];
  }
  public static function insertHead($head){
      $sql = Helper::fill_in(Head::$methods['insert'],array(
        $head->title,
        $head->desc,
        $head->robots,
        $head->pages_id_page
      ));
      return Database::insert($sql);
  }
  public static function deleteHead($id){
      $sql = Helper::fill_in(Head::$methods['delete'],array($id));
      return Database::delete($sql);
  }
  public static function updateHead($head){
      $sql = Helper::fill_in(Head::$methods['update'],array(
          $head->title,
          $head->desc,
          $head->pages_id_page,
          $head->robots,
          $head->id
        ));
      return Database::update($sql); 
  }
}