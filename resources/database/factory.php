<?php
    include "../elements/database.php";
    define("USERNAME_POOL",explode(" ","rope beauty mourn tired throughout roll tap paint sentence mom defeat roll salt nice beard act boyfriend worry stun angel describe glass desperately point army within advice morning goose kid football answer skip half feather quite cookie trust vain peace lazy easy puzzle easy lazy blind vain lot thrown rise rough near prince afraid honey trust murder return begun rose mourn held feather held subject drive cease blind bump sad screw quite advice half claw hour group fact machine window stair blind fog music yesterday paint neither emotion wow beneath bump return wow afraid neighbor hour canvas shine limb question faint within shore drop doll chance advice quite shimmer quite insult children remove flow serious dad peaceful kid cookie street cease secret illuminate apart steady notice poetry point shore silence cheer bright rich drop rough drop arrive follow nearly path price empty peaceful whisper guilt notice screw anymore tough song tease earth goal both glare both limb beauty tangle shine illuminate began dove began thrown notice hum already led brother insult sorry cease house appreciate brother mourn apart mass heard student shine carve began shield began insult shine sanctuary heard stolen already shiny okay nearly color feather earth hatred earth commit song crystal color delight color yesterday okay hop dear throughout okay army anymore army almost subject along moonlight push bank step guard second clutch reach cheer reach cheer reason clutch fire clutch line commit guy crystal today delight land doll finally doll young"));
    define("UPOOL_ENTROPY", count(USERNAME_POOL));
    define("ALPHA",explode(" ","q w e r t y u i o p a s d f g h j k l z x c v b n m"));
    define("ALPHA_L",count(ALPHA));

    //helper functions
    function str_contains(string $haystack, string $needle): bool{
      return '' === $needle || false !== strpos($haystack, $needle);
    }
    function fill_in($str,$data){
      //this funct inserts data into strings at specified places
      $head="%0";
      $pos=0;
      while (str_contains($str,$head)) {

        $str=str_replace($head,$data[$pos],$str);
        $pos++;
        $head="%$pos";
      }
      return $str;
    }
    function genRandomWord(){
      //this helper funct gens random words
      //a word is on average 2~7 char. long
      $word_len = rand(2,7);
      $word = "";
      for ($i=0; $i < $word_len; $i++) {
        $word.=ALPHA[rand(0,ALPHA_L-1)];
      }
      return array('word'=>$word,'len'=>$word_len);
    }
    function selectRandom($col,$table){
      //this helper function pulls random row id from db, in order to
      //properly populate tables requiring relationships
      $sql = "SELECT `$col` FROM `$table` ORDER BY RAND() LIMIT 1;";
      $c = connect();
      $result = mysqli_query($c, $sql);
      if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result)[$col];
        }
      }

    function insert($sql){
      $c = connect();
      if ($c->query($sql) === TRUE) {
          echo "Records inserted<br>";
          } else {
          echo "Error: <br>" . $c->error;
          }
      $c->close();
    }

    //main functions
    $genRandomUser = function(){
      //generates random user
        $pass=crypt(uniqid("p"));
        $username_pre=USERNAME_POOL[rand(0,UPOOL_ENTROPY-1)];
        $username_suf=USERNAME_POOL[rand(0,UPOOL_ENTROPY-1)];
        $usrn=$username_pre."_".$username_suf.rand(5,12767);
        return array($usrn, $pass);
    };
    $genRandomLeaflet = function(){
      //generates random fic page
      //fic pages have on average 10 000 - 12 000 chars.
      //decide at random, the length of the fic
      $length = rand(9000,12000);
      $body = "";

      //now, generate random words and substract their length from total length limit
      while($length > 0){
        $word=genRandomWord();
        $length=$length-$word['len'];
        $body.=$word['word']." ";
      }
      return array($body,selectRandom('id_publication','publications'));
    };
    $genRandomFandom = function(){
      //this function generates `friendly_name`, `name`
      //fandoms have on average 4 to 12 word long names
      $length = rand(24,60);
      $friendly_name = "";
      while ($length > 0) {
        $word = genRandomWord();
        $friendly_name.=$word['word']." ";
        $length=$length-$word['len'];
      }
      $name=str_replace(" ","-",$friendly_name);
      return array($friendly_name,$name);
    };
    $genRandomPublication = function(){
      //this function must randomly generate
      // `title`, `body`, `planned_length`, `status`, `time_stamp`, `users_id_user`, `fandoms_id_fandom`
      $title = "";
      $title_length = rand(24,60);
      while ($title_length > 0) {
        $word = genRandomWord();
        $title.=$word['word']." ";
        $title_length=$title_length-$word['len'];
      }
      //this can be either undefined (0) or between 1 and 12
      $planned_length = rand(0,12);
      //status is true (finished or 1) or false (unfinished or 0)
      //if status is true, planned len must be same as num of uploaded leaflets
      $status=rand(0,1);
      $users_id_user = selectRandom("id_user","users");
      $fandoms_id_fandom = selectRandom("id_fandom","fandoms");
      return array(
        $title,
        $planned_length,
        $status,
        $users_id_user,
        $fandoms_id_fandom
      );
    };

    function manufacture($method,$n,$f){
    //this function prepares sql statements using output from a function passed to it
      $head_tail=explode("VALUES",INSERT_METHODS[$method]);
      $sql=$head_tail[0]." VALUES ";
      for ($i=0; $i < $n; $i++) {
        $sql.=fill_in($head_tail[1],$f()).",";
      }
      $sql.=fill_in($head_tail[1],$f()).";";
      return $sql;
    }
    //------ main logic ------
      //define limits
      
      $users = 50;
      $fandoms = 10;
      $publications = $fandoms*5;
      $leaflets = $publications*100;
      
      echo "GEN $users USERS<br>";
      $sql = manufacture('users',$users,$genRandomUser);
      insert($sql);
      
      echo "GEN $fandoms FANDOMS<br>";
      $sql = manufacture('fandom',$fandoms,$genRandomFandom);
      insert($sql);
      
      echo "GEN $publications PUBLICATIONS<br>";
      $sql = manufacture('publication',$publications,$genRandomPublication);
      insert($sql);  
       
      
      echo "GEN $leaflets LEAFLETS<br>";
      //this is memory intensive. do it 50 leaflets at a time 
      while($leaflets > 0){
        $sql = manufacture('leaflet',50,$genRandomLeaflet);
        insert($sql); 
        unset($sql);
        $leaflets=$leaflets-10;
      } 
      
?>
