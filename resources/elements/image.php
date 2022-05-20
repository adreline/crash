<?php
//this class defines a fandom db object
namespace Elements;
use Crash\Helper;
use Elements\Database;

class Image{
public $id;
public $alt;
public $path;
public $created_at;
public $updated_at;

function __construct($alt="",$path="",$id=0,$created_at=null,$updated_at=null){
    $this->alt = $alt;
    $this->path = $path;
    $this->id = $id;
    $this->created_at = $created_at;
    $this->updated_at = $updated_at;
}

private static $methods = array(
    'insert' => "INSERT INTO `images` (`id_image`, `alt`, `path`, `created_at`, `updated_at`) VALUES (NULL, '%0', '%1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
    'select' => "SELECT * FROM  `images`",
    'delete' => "DELETE FROM `images` WHERE `images`.`id_image` = %0",
    'update' => "UPDATE `images` SET `alt` = '%0', `path` = '%1', `updated_at`=CURRENT_TIMESTAMP WHERE `images`.`id_image` = %2"
);
private static function getImage($optional_sql=""){
       $sql = Image::$methods['select'].$optional_sql;
       return Database::select($sql, function($row){
             return new Image(
               $row['alt'],
               $row['path'],
               $row['id_image'],
               $row['created_at'],
               $row['updated_at']
             );
       });
}
public static function getImageById($id){
    return Image::getImage("WHERE `images`.`id_image`=$id")[0];
}
public static function getImageByFilename($filename){
    return Image::getImage("WHERE `images`.`path` LIKE '$filename'")[0];
}
public static function insertImage($image){
    $sql = Helper::fill_in(Image::$methods['insert'],array($image->alt,$image->path));
    return Database::insert($sql);
}
public static function deleteImage($id){
    $sql = Helper::fill_in(Image::$methods['delete'],array($id));
    return Database::delete($sql);
} 

public static function saveImageAsFile($file){
    $filename = basename($file["name"]);
    $root = "/crash/public/img/"; //image filesystem root
    $extension = strtolower(pathinfo($filename,PATHINFO_EXTENSION));
    $size = ($file["size"])/1000000; //get size in MB
    $max_size = 5; //allow 5MB at max
    $allowed_formats = array("jpg","png","jpeg");
    //validate image
    if(!(in_array($extension, $allowed_formats) && $size<$max_size)) return null;
    //valid, now gen new name and save it
    $filename = $root.uniqid("crash_").".".$extension;
    return (move_uploaded_file($file["tmp_name"], $filename)) ? $filename : null;
}   
}
?>