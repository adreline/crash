<?php
    require "crash/.env";

    define("METHODS",array(
        "test" => "SELECT * FROM test"
    ));
    define("INSERT_METHODS",array(
      'users'=>"INSERT INTO `users` (`id_user`, `username`, `password`, `time_stamp`) VALUES (NULL, '%0', '%1', CURRENT_TIMESTAMP)",
      'leaflet'=>"INSERT INTO `leafs` (`id_leaf`, `body`, `publications_id_publication`) VALUES (NULL, '%0', '%1')",
      'fandom'=>"INSERT INTO `fandoms` (`id_fandom`, `friendly_name`, `name`) VALUES (NULL, '%0', '%1')",
      'publication'=>"INSERT INTO `publications` (`id_publication`, `title`, `planned_length`, `status`, `time_stamp`, `users_id_user`, `fandoms_id_fandom`) VALUES (NULL, '%0', '%1', '%2', CURRENT_TIMESTAMP, '%3', '%4')"
    ));

    function connect(){
        $c =  mysqli_connect(DB_CONF['host'],DB_CONF['database_user'],DB_CONF['database_pass'],DB_CONF['database']);
        if(!$c){
            die("Connection error");
        }else{
            return $c;
        }
    }
    /*
    function getTest(){
        $c = connect();
        $result = mysqli_query($c, METHODS['test']);
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while($row = mysqli_fetch_assoc($result)) {
            echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
          }
        } else {
          echo "0 results";
        }

        mysqli_close($c);
    }
    */
?>
