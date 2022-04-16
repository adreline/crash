<?php 
    include "elements/database.php";
    define("USERNAME_POOL",explode(" ","rope beauty mourn tired throughout roll tap paint sentence mom defeat roll salt nice beard act boyfriend worry stun angel describe glass desperately point army within advice morning goose kid football answer skip half feather quite cookie trust vain peace lazy easy puzzle easy lazy blind vain lot thrown rise rough near prince afraid honey trust murder return begun rose mourn held feather held subject drive cease blind bump sad screw quite advice half claw hour group fact machine window stair blind fog music yesterday paint neither emotion wow beneath bump return wow afraid neighbor hour canvas shine limb question faint within shore drop doll chance advice quite shimmer quite insult children remove flow serious dad peaceful kid cookie street cease secret illuminate apart steady notice poetry point shore silence cheer bright rich drop rough drop arrive follow nearly path price empty peaceful whisper guilt notice screw anymore tough song tease earth goal both glare both limb beauty tangle shine illuminate began dove began thrown notice hum already led brother insult sorry cease house appreciate brother mourn apart mass heard student shine carve began shield began insult shine sanctuary heard stolen already shiny okay nearly color feather earth hatred earth commit song crystal color delight color yesterday okay hop dear throughout okay army anymore army almost subject along moonlight push bank step guard second clutch reach cheer reach cheer reason clutch fire clutch line commit guy crystal today delight land doll finally doll young"));
    define("UPOOL_ENTROPY", count(USERNAME_POOL));

    function genRandomUser(){
        $pass=crypt(uniqid("p"));
        $username_pre=USERNAME_POOL[rand(0,UPOOL_ENTROPY-1)];
        $username_suf=USERNAME_POOL[rand(0,UPOOL_ENTROPY-1)];
        $usrn=$username_pre."_".$username_suf.rand(5,12767);
        return array("username"=>$usrn, "password"=>$pass);
    }
    
    $c = connect();
    for ($i=0; $i < 10; $i++) { 
        $sql = "INSERT INTO `users` (`id_user`, `username`, `password`, `time_stamp`) VALUES (NULL, '$usrn', '$pass', CURRENT_TIMESTAMP);";
        if ($c->query($sql) === TRUE) {
            echo "New record created successfully";
            } else {
            echo "Error: " . $sql . "<br>" . $c->error;
            }
    }

    $c->close();
?>