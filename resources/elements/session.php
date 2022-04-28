<?php
namespace Elements;
//this class defines a session db object
use Elements\Database as Database;
use Crash\Helper as Helper;

class Session{
    public $id;
    public $secret;
    public $users_id_user;
    public $created_at;

    function __construct($secret,$users_id_user,$created_at=null,$id=null){
        $this->secret = $secret;
        $this->users_id_user = $users_id_user;
        $this->created_at = $created_at;
        $this->id = $id;
    }

    private static $methods = array(
        'insert'=>"INSERT INTO `sessions` (`id_session`, `secret`, `users_id_user`) VALUES (NULL, '%0', '%1');",
        'select'=>"SELECT * FROM `sessions` WHERE `secret`='%0'",
        'delete'=>"DELETE FROM `sessions` WHERE `sessions`.`id_session` = %0",
        'update'=>"UPDATE `sessions` SET `secret` = '%0', `users_id_user` = '%1' WHERE `sessions`.`id_session` = %2;"
      );
    //it doesn't make sense to pull all sessions so just fetch one by it's secret
    public static function getSession($secret){
        $sql = Helper::fill_in(Session::$methods['select'],array($secret));
        $sessions = Database::select($sql,function($row){
            return new Session(
                $row['secret'],
                $row['users_id_user'],
                $row['created_at'],
                $row['id_session']
            );
        });
        if(sizeof($sessions)==1){
            return $sessions[0]; //by default db will return an array, so we need to pull first element
        }else{
            return null;
        }
        
    }
    public static function insertSession($session){
        $sql = Helper::fill_in(Session::$methods['insert'],array(
            $session->secret,
            $session->users_id_user
        ));
        if(Database::insert($sql)){
            echo "Inserted";
          }else{
            echo "Failed to insert";
          }
    }
    public static function deleteSession($id){
        $sql = Helper::fill_in(Session::$methods['delete'],array($id));
        if(Database::delete($sql)){
            echo "Deleted";
          }else{
            echo "Failed to delete";
          }
    }
    public static function updateSession($session){
        $sql= Helper::fill_in(Session::$methods['update'],array(
            $session->secret,
            $session->users_id_user,
            $session->id
        ));
        if(Database::update($sql)){
            echo "Updated";
          }else{
            echo "Failed to update";
          }
    }

}

?>
