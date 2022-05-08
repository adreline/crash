<?php
    namespace Elements;
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
            if(!$result){
                return [];
            }
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) { 
                    $results[]=$f($row);
                }
            } else {
                return [];
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
                define("mysql_error",$c->error);
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
