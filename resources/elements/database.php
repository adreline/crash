<?php
    require "crash/.env";
    define("METHODS",array(
        "test" => "SELECT * FROM test"
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