<?php
namespace Elements;
//this class defines a user db object
use Elements\Database;
use Crash\Helper;

class Comment{
    public $id_comment;
    public $users_id_user;
    public $publications_id_publication;
    public $body;
    public $created_at;
    public $updated_at;


function __construct($users_id_user=0,$publications_id_publication=0,$body="",$id_comment=0,$created_at=null,$updated_at=null){
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

private static function getComments($optional_sql=""){
       $sql = Comment::$methods['select']." ".$optional_sql;
    return Database::select($sql, function($row){
        return new Comment(
            $row['users_id_user'],
            $row['publications_id_publication'],
            $row['body'],
            $row['id_comment'],
            $row['created_at'],
            $row['updated_at']
        );
    });
}
public static function getCommentById($id_comment){
    return Comment::getComments("WHERE `comments`.`id_comment`=$id_comment")[0];
}
public static function getPublicationComments($id_pub){
    return Comment::getComments("WHERE `comments`.`publications_id_publication`=$id_pub");
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
}