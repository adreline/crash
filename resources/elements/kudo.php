<?php
namespace Elements;
//this class defines a user db object
use Elements\Database as Database;
use Crash\Helper as Helper;
use Elements\Publication as Publication;

class Kudo{
    public $users_id_user;
    public $publications_id_publication;
    public $created_at;

    function __construct($users_id_user,$publications_id_publication,$created_at=null){
        $this->users_id_user = $users_id_user;
        $this->publications_id_publication = $publications_id_publication;
        $this->created_at = $created_at;
    }

    private static $methods = array(
        'insert' => "INSERT INTO `kudos` (`users_id_user`, `publications_id_publication`, `created_at`) VALUES ('%0', '%1', CURRENT_TIMESTAMP) ",
        'delete' => "DELETE FROM `kudos` WHERE `kudos`.`users_id_user`=%0 AND `kudos`.`publications_id_publication`=%1",
        'fetch_by_user' => "SELECT * FROM `kudos` WHERE `kudos`.`users_id_user`=%0",
        'fetch_by_pub' => "SELECT * FROM `kudos` WHERE `kudos`.`publications_id_publication`=%0",
        'fetch_by_pub_and_user' => "SELECT * FROM `kudos` WHERE `kudos`.`users_id_user`=%0 AND `kudos`.`publications_id_publication`=%1",
        'count_user_kudos' => "SELECT COUNT(`users_id_user`) AS `number` FROM `kudos` WHERE `kudos`.`users_id_user`=%0",
        'count_pub_kudos' => "SELECT COUNT(`publications_id_publication`) AS `number` FROM `kudos` WHERE `kudos`.`publications_id_publication`=%0"
    );
    public static function getKudosByUserId($id_user){
      $sql = Helper::fill_in(Kudo::$methods['fetch_by_user'],array($id_user));
      return Database::select($sql,function ($row){
          return new Kudo(
              $row['users_id_user'],
              $row['publications_id_publication'],
              $row['created_at']
          );
      });
    }
    public static function getKudosByPublicationId($id_publication){
        $sql = Helper::fill_in(Kudo::$methods['fetch_by_pub'],array($id_publication));
        return Database::select($sql);
    }
    public static function insertKudo($id_user,$id_publication){
        $sql = Helper::fill_in(Kudo::$methods['insert'],array($id_user,$id_publication));
        return Database::insert($sql);
    }
    public static function deleteKudo($id_user,$id_publication){
        $sql = Helper::fill_in(Kudo::$methods['delete'],array($id_user,$id_publication));
        return Database::delete($sql);
    }
    public static function kudoExists($id_user,$id_publication){
        $sql = Helper::fill_in(Kudo::$methods['fetch_by_pub_and_user'],array($id_user,$id_publication));
        $result = Database::select($sql,function ($row){
            return new Kudo(
                $row['users_id_user'],
                $row['publications_id_publication'],
                $row['created_at']
            );
        });
        if(sizeof($result)==1){
            return true;
        }else{
            return false;
        }
    }   
    public static function countUserKudosById($user_id){
        $sql = Helper::fill_in(Kudo::$methods['count_user_kudos'],array($user_id));
        return Database::select($sql,function ($row){
            return $row['number'];
        })[0];
    }
    public static function countPublicationKudosById($id_publication){
        $sql = Helper::fill_in(Kudo::$methods['count_pub_kudos'],array($id_publication));
        return Database::select($sql,function ($row){
            return $row['number'];
        })[0];
    }
}