<?php
    namespace Elements;
    class Database{
        public static function connect(){
            $c =  mysqli_connect(DB_CONF['host'],DB_CONF['database_user'],DB_CONF['database_pass'],DB_CONF['database']);
            if(!$c){
                die("Connection error");
            }else{
                return $c;
            }
        }
        public static function select($method,$f){
            global $DB_CONNECTION;
            $c = $DB_CONNECTION;
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
            return $results;
        }
        public static function insert($sql){
            global $DB_CONNECTION;
            $c = $DB_CONNECTION;
            if ($c->query($sql) === TRUE) {
                return true;
            } else {
                define("mysql_error",$sql."<br>".$c->error);
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
