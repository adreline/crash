<?php
namespace Elements;
//this class defines a session db object
use Elements\Database;
use Crash\Helper;

class Session{
    public $id;
    public $secret;
    public $users_id_user;
    public $created_at;

    function __construct($secret,$users_id_user,$id=0,$created_at=null){
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
        return Database::select($sql,function($row){
            return new Session(
                $row['secret'],
                $row['users_id_user'],
                $row['created_at'],
                $row['id_session']
            );
        })[0];
    }
    public static function insertSession($session){
        $sql = Helper::fill_in(Session::$methods['insert'],array(
            $session->secret,
            $session->users_id_user
        ));
        return Database::insert($sql);
    }
    public static function deleteSession($id){
        $sql = Helper::fill_in(Session::$methods['delete'],array($id));
        return Database::delete($sql);
    }
    public static function updateSession($session){
        $sql= Helper::fill_in(Session::$methods['update'],array(
            $session->secret,
            $session->users_id_user,
            $session->id
        ));
        return Database::update($sql);
    }

}

?>
