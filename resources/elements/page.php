<?php 
//this class defines the webpage object. do not confuse it with leaflet 
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;

class Page{
    public $id;
    public $name;
    public $friendly_name;
    public $content;
    public $custom_css;
    public $javascript;

    function __construct($name, $friendly_name, $content, $custom_css="", $javascript="",$id=null){
        $this->id = $id;
        $this->name = $name;
        $this->friendly_name = $friendly_name;
        $this->content = $content;
        $this->custom_css = $custom_css;
        $this->javascript = $javascript;
    }

    private static $methods = array(
        'insert' => "INSERT INTO `pages` (`id_page`, `friendly_name`, `name`, `content`, `custom_css`, `javascript`) VALUES (NULL, '%0', '%1', '%2', '%3', '%4')",
        'select' => "SELECT * FROM `pages`",
        'update' => "UPDATE `pages` SET `friendly_name` = '%0', `name` = '%1', `content` = '%2', `custom_css` = '%3', `javascript` = '%4' WHERE `pages`.`id_page` = %5",
        'delete' => "DELETE FROM `pages` WHERE `pages`.`id_page` = %0",
        'exists' => "SELECT id_page FROM `pages` WHERE `pages`.`name` = '%0'"
    );
    public static function fetchPageByName($name){
        //this function returns either id of a page or -1 if page is not found.
        $sql = Helper::fill_in(Page::$methods['exists'],array($name));
        $id = Database::select($sql, function ($row){
            return $row['id_page'];
        });
        if(sizeof($id)==1){
            return $id[0];
        }else{
            return -1;
        }
    }
    public static function getPage($id=null, $optional_sql=""){
        if(isset($id)){
            $optional_sql="WHERE id_page=$id ".$optional_sql;
        }
        $sql = Page::$methods['select'].$optional_sql;
        $pages = Database::select($sql, function ($row){
            return new Page($row['name'],$row['friendly_name'],$row['content'],$row['custom_css'],$row['javascript'],$row['id_page']);
        });
        if(sizeof($pages)==0){
            return null;
        }else{
            return $pages;
        }
         
    }
    public static function insertPage($page){
        $sql = Helper::fill_in(Page::$methods['insert'],array($page->friendly_name, $page->name, $page->content, $page->custom_css, $page->javascript));
        if(Database::insert($sql)){
            echo "Inserted";
        }else{
            echo "Failed to insert";
        }
    }
    public static function deletePage($id){
        $sql = Helper::fill_in(Page::$methods['delete'],array($id));
        if(Database::delete($sql)){
            echo "Deleted";
        }else{
            echo "Failed to delete";
        }
    }
    public static function editPage($id,$page){
        $sql = Helper::fill_in(Page::$methods['update'],array($page->friendly_name, $page->name, $page->content, $page->custom_css, $page->javascript,$id));
        if(Database::update($sql)){
            echo "Updated";
        }else{
            echo "Failed to update";
        }
    }

}

?>