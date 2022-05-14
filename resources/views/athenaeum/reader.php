<?php
    use Crash\Crash as Crash;
    use Elements\Kudo;
    $p = $_SESSION['protagonist'];
?>
<!DOCTYPE html>
<?php
    include Crash::$module['head'];
?>
    <body>
    <?php
        include Crash::$module['navbar'];
    ?>
        <div class="columns">
            <div class="column">
                <div class="window">
                    <h2 class="title"><?php echo "$publication->title"; ?></h2>
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                               <?php 
                               if(!Kudo::kudoExists($p->id,$publication->id)){
                                echo "<a href=\"/crash/athenaeum/kudo/give?id_user=$p->id&id_publication=$publication->id\"><mark class=\"success\">[leave kudo]</mark></a>"; 
                               }else{
                                echo "<a href=\"/crash/athenaeum/kudo/withdraw?id_user=$p->id&id_publication=$publication->id\"><mark class=\"danger\">[withdraw kudo]</mark></a>"; 
                               }                               
                               ?>
                            </div>
                            <div class="column">

                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <?php
                            foreach ($leafs as $leaf) {
                                echo "<h3>$leaf->title</h3>";
                                echo "<br>";
                                echo htmlspecialchars_decode($leaf->body, ENT_QUOTES);
                                echo "<br><br>";
                            } 
                        ?>
                
                    </div>
                </div>
            </div>
            <div class="column is-1-4">
                <?php include Crash::$module['aside']; ?>
            </div>
        </div>
    </body>
