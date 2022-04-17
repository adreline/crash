<?php
    require "crash/.env";
    
    define("INSERT_METHODS",array(
      'users'=>"INSERT INTO `users` (`id_user`, `username`, `password`, `time_stamp`) VALUES (NULL, '%0', '%1', CURRENT_TIMESTAMP)",
      'leaflet'=>"INSERT INTO `leafs` (`id_leaf`, `body`, `publications_id_publication`) VALUES (NULL, '%0', '%1')",
      'publication'=>"INSERT INTO `publications` (`id_publication`, `title`, `planned_length`, `status`, `time_stamp`, `users_id_user`, `fandoms_id_fandom`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP, '%3', '%4')"
    ));
    class Database{
        private static function connect(){
            $c =  mysqli_connect(DB_CONF['host'],DB_CONF['database_user'],DB_CONF['database_pass'],DB_CONF['database']);
            if(!$c){
                die("Connection error");
            }else{
                return $c;
            }
        }
        public static function select($method,$f){
            $c = Database::connect();
            $results;
            $result = mysqli_query($c, $method);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) { 
                    $results[]=$f($row);
                }
            } else {
                echo "0 results";
            }
            mysqli_close($c);
            return $results;
        }
        public static function insert($sql){
            $c = Database::connect();
            if ($c->query($sql) === TRUE) {
                $c->close();
                return true;
            } else {
                $c->close();
                return false;
            }
        }
        public static function delete($sql){
           //welp, turns out it will be the same as insert
           return Database::insert($sql); 
        }
        public static function update($sql){
           //welp, turns out it will be the same as insert
           return Database::insert($sql); 
        }
        
    }
    //main functions
?>
