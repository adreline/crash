<?php
namespace Elements;
//this class defines a tag db object as well as mock table m:m
use Elements\Database;
use Crash\Helper;

class Tag{
public $id;
public $friendly_name;
public $name;
public $created_at;
public $updated_at;

function __construct($friendly_name="", $name="",$id=0, $created_at=null, $updated_at=null){
    $this->friendly_name = $friendly_name;
    $this->name = $name;
    $this->id = $id;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
}
private static $methods = array(
    'insert' => "INSERT INTO `tags` (`id_tag`, `friendly_name`, `name`, `created_at`, `updated_at`) VALUES (NULL, '%0', '%1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP) ",
    'select' => "SELECT * FROM `tags`"
);
public static function attachTag($id_pub,$id_tag){
    return TagHasPublication::attachTag($id_pub,$id_tag);
}
public static function unattachTag($id_pub,$id_tag){
    return TagHasPublication::unattachTag($id_pub,$id_tag);
}
public static function tagExists($friendly_name){
    return (sizeof(Tag::getTags("WHERE `tags`.`friendly_name` LIKE '$friendly_name'"))!=0) ? true : false;
}
public static function getPublicationTags($id_pub){
    $tags = array();
    foreach(TagHasPublication::getPublicationTags($id_pub) as $mock_row){
        $tags[] = Tag::getTagById($mock_row->tags_id_tag);
    }
    return $tags;
}
public static function getTagPublications($id_tag){
    $pubs = array();
    foreach(TagHasPublication::getTagPublications($id_tag) as $mock_row){
        $pubs[] = Publication::getPublicationById($mock_row->publications_id_publication);
    }
    return $pubs;
}
public static function getTagByName($friendly_name){
    return Tag::getTags("WHERE `tags`.`friendly_name` LIKE '$friendly_name'")[0];
}
public static function getTagById($id_tag){
    return Tag::getTags("WHERE `tags`.`id_tag`=$id_tag")[0];
}
private static function getTags($optional_sql=""){
      $sql = Tag::$methods['select']." ".$optional_sql;
      return Database::select($sql, function($row){
          return new Tag(
            $row['friendly_name'],
            $row['name'],
            $row['id_tag'],
            $row['created_at'],
            $row['updated_at']
          );
      });
}
public static function insert($tag){
    $sql = Helper::fill_in(Tag::$methods['insert'],array($tag->friendly_name,$tag->name));
    return Database::insert($sql);
}

}
class TagHasPublication{
    public $tags_id_tag;
    public $publications_id_publication;

    function __construct($tags_id_tag,$publications_id_publication){
        $this->tags_id_tag = $tags_id_tag;
        $this->publications_id_publication = $publications_id_publication;    
    }
    private static $methods = array(
        'insert' => "INSERT INTO `tags_has_publications` (`tags_id_tag`, `publications_id_publication`) VALUES ('%0','%1')",
        'select' => "SELECT * FROM `tags_has_publications`",
        'delete' => "DELETE FROM `tags_has_publications` WHERE `tags_has_publications`.`tags_id_tag`=%0 AND `tags_has_publications`.`publications_id_publication`=%1"
    );
    public static function unattachTag($id_pub,$id_tag){
        $sql = Helper::fill_in(TagHasPublication::$methods['delete'], array($id_tag,$id_pub));
        return Database::delete($sql);
    }
    public static function attachTag($id_pub,$id_tag){
        $sql = Helper::fill_in(TagHasPublication::$methods['insert'], array($id_tag,$id_pub));
        return Database::insert($sql);
    }
    public static function getTagPublications($id_tag){
        $sql = TagHasPublication::$methods['select']." WHERE `tags_has_publications`.`tags_id_tag`=$id_tag";
        return Database::select($sql, function($row){
            return new TagHasPublication(
                $row['tags_id_tag'],
                $row['publications_id_publication']
            );
        });
    }
    public static function getPublicationTags($id_pub){
        $sql = TagHasPublication::$methods['select']." WHERE `tags_has_publications`.`publications_id_publication`=$id_pub";
        return Database::select($sql, function($row){
            return new TagHasPublication(
                $row['tags_id_tag'],
                $row['publications_id_publication']
            );
        });
    }
}
?>