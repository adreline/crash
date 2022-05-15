<?php 
//this class defines the webpage object. do not confuse it with leaflet 
namespace Elements;
use Crash\Helper as Helper;
use Elements\Database as Database;
use Elements\Head as Head;

class Page{
    public $id;
    public $friendly_name;
    public $name;
    public $content;
    public $custom_css;
    public $javascript;
    public $created_at;
    public $updated_at;

    function __construct($name="", $friendly_name="", $content="", $custom_css="", $javascript="",$id=null,$created_at=null,$updated_at=null){
        $this->id = $id;
        $this->name = $name;
        $this->friendly_name = $friendly_name;
        $this->content = $content;
        $this->custom_css = $custom_css;
        $this->javascript = $javascript;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    private static $methods = array(
        'insert' => "INSERT INTO `pages` (`id_page`, `friendly_name`, `name`, `content`, `custom_css`, `javascript`, `created_at`,`updated_at`) VALUES (NULL, '%0', '%1', '%2', '%3', '%4', CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)",
        'select' => "SELECT * FROM `pages`",
        'update' => "UPDATE `pages` SET `friendly_name` = '%0', `name` = '%1', `content` = '%2', `custom_css` = '%3', `javascript` = '%4',`updated_at`=CURRENT_TIMESTAMP WHERE `pages`.`id_page` = %5",
        'delete' => "DELETE FROM `pages` WHERE `pages`.`id_page` = %0"
    );

    public static function getPage($id=null, $optional_sql=""){
        if(isset($id)){
            $optional_sql="WHERE id_page=$id ".$optional_sql;
        }
        $sql = Page::$methods['select'].$optional_sql;
        return Database::select($sql, function ($row){
            return new Page(
                $row['name'],
                $row['friendly_name'],
                $row['content'],
                $row['custom_css'],
                $row['javascript'],
                $row['id_page'],
                $row['created_at'],
                $row['updated_at']);
        });       
    }
    public static function getPageByName($name){
        return Page::getPage(null, "WHERE `pages`.`name` LIKE '$name'")[0];
    }
    public static function getPageById($id_page){
        return Page::getPage($id_page)[0];
    }
    public static function insertPage($page){
        $sql = Helper::fill_in(Page::$methods['insert'],array(
            $page->friendly_name,
            $page->name,
            $page->content,
            $page->custom_css,
            $page->javascript));
            
        return Database::insert($sql);
    }
    public static function deletePage($id){
        $sql = Helper::fill_in(Page::$methods['delete'],array($id));
        return Database::delete($sql);
    }
    public static function editPage($page){
        $sql = Helper::fill_in(Page::$methods['update'],array($page->friendly_name, $page->name, $page->content, $page->custom_css, $page->javascript,$page->id));
        return Database::update($sql);
    }
    public static function getHead($id_page){
        return Head::getHead($id_page);
    }

}

?>
