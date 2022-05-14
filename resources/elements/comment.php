<?php
namespace Elements;
//this class defines a user db object
use Elements\Database as Database;
use Crash\Helper as Helper;

class Comment{
    public $id_comment;
    public $users_id_user;
    public $publications_id_publication;
    public $body;
    public $created_at;
    public $updated_at;
}

function __construct($users_id_user=0,$publications_id_publication=0,$body="",$created_at=null,$updated_at=null,$id_comment=null){
    $this->id_comment = $id_comment;
    $this->users_id_user = $users_id_user;
    $this->publications_id_publication = $publications_id_publication;
    $this->body = $body;
  }

private static $methods = array(
    'insert' => "INSERT INTO `comments` (`id_comment`, `users_id_user`, `publications_id_publication`, `body`, `created_at`, `updated_at`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)",
    'select' => "SELECT * FROM `comments`",
    'delete' => "DELETE FROM `comments` WHERE `comments`.`id_comment` = %0",
    'update' => "UPDATE `comments` SET `body` = '%0', `updated_at` = CURRENT_TIMESTAMP WHERE `comments`.`id_comment` = %1"
);

public static function getComment($id=null,$optional_sql=""){
    if(isset($id)){
        $optional_sql="WHERE id_fandom=$id ".$optional_sql;
       }
       $sql = Comment::$methods['select'].$optional_sql;
    return Database::select($sql, function($row){
        return new Comment(
            $row['users_id_user'],
            $row['publications_id_publication'],
            $row['body'],
            $row['created_at'],
            $row['updated_at'],
            $row['id_comment']
        );
    });
}
public static function getPublicationComments($id_pub){
    return Comment::getComment(null,"WHERE `comments`.`publications_id_publication`=$id_pub");
}
public static function insertComment($comment){
    $sql = Helper::fill_in(Comment::$methods['insert'],array(
        $comment->users_id_user,
        $comment->publications_id_publication,
        $comment->body
    ));
    return Database::insert($sql);
}
public static function deleteComment($id_comment){
    $sql = Helper::fill_in(Comment::$methods['delete'],array($id_comment));
    return Database::delete($sql);
}
public static function updateComment($comment){
    $sql = Helper::fill_in(Comment::$methods['insert'],array(
        $comment->body,
        $comment->id
    ));
    return Database::insert($sql);
}